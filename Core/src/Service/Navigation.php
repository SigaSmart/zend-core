<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 26/12/2017
 * Time: 23:11
 */

namespace Core\Service;


use Admin\Table\MenuTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Sql\Predicate\IsNull;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Db\Sql\Select;
use Zend\Navigation\Service\DefaultNavigationFactory;

class Navigation extends DefaultNavigationFactory
{

	/**
	 * @param ContainerInterface $serviceLocator
	 *
	 * @return array
	 * @return array
	 */
	protected function getPages(ContainerInterface $serviceLocator)
	{
		if (null === $this->pages) {
			/**
			 * @var $fetchMenu MenuTable
			 */
			$fetchMenu = $serviceLocator->get(MenuTable::class);
			$Menu= $fetchMenu->getSelect()->where(new IsNull('parent'));
            $Menu->join( ['b' => 'resources'],        // join table with alias
				'menus.route = b.id',  // join expression
				['alias','route'], $Menu::JOIN_LEFT);
			$Menu->where(['menus.status'=>1]);
			$Menu->order('menus.ordem',"DESC");
			$fetchMenu->setStmt($fetchMenu->getSql()->prepareStatementForSqlObject($Menu));
			$fetchMenu->exec();

			if($fetchMenu->getResultSet()->count()):
				$Datas = $fetchMenu->getResultSet()->toArray();
				foreach($Datas as $key=>$row)
				{
					$Pages=[];
					$SubMenu= $fetchMenu->getSelect()->where(new Operator('parent',Operator::OP_EQ, $row['id']));
					$SubMenu->where(['menus.status'=>1]);
					$SubMenu->join( ['b' => 'resources'],        // join table with alias
						'menus.route = b.id',  // join expression
						['route']);
					$SubMenu->order('menus.ordem',"DESC");
					$fetchMenu->setStmt($fetchMenu->getSql()->prepareStatementForSqlObject($SubMenu));
					$fetchMenu->exec();
					if($fetchMenu->getResultSet()->count()):
						$SubDatas = $fetchMenu->getResultSet()->toArray();
						foreach($SubDatas as $subrow)
						{
							$Pages[]= [
								'label' => $subrow['name'],
								'route' => sprintf("%s/default",$subrow['route']),
								'controller' => $subrow['controller'],
								'privilege' => $subrow['action'],
								'action' => $subrow['action'],
								'resource' => $subrow['alias'],
								'role' => $subrow['role'],
								'icone' => $subrow['icone'],
								'pages'=>[
									[
										'label' => $subrow['name'],
										'route' => sprintf("%s/default",$subrow['route']),
										'privilege' => 'editar',
										'controller' => $subrow['controller'],
										'action' => 'editar',
										'resource' => $subrow['alias'],
										'role' => $subrow['role']
									]
								]
							];
						}
					endif;
					$configuration['navigation'][$this->getName()][$row['name']] = [
						'label' => $row['name'],
						'route' => $row['route'],
						'controller' => $row['controller'],
						'action' => $row['action'],
						'privilege' => $row['action'],
						'resource' => $row['alias'],
						'role' => $row['role'],
						'icone' => $row['icone'],
						'pages'=>$Pages
					];

				}
			endif;
			if (!isset($configuration['navigation'])) {
				throw new \InvalidArgumentException('Could not find navigation configuration key');
			}
			if (!isset($configuration['navigation'][$this->getName()])) {
				throw new \InvalidArgumentException(sprintf(
					'Failed to find a navigation container by the name "%s"',
					$this->getName()
				));
			}

			$application = $serviceLocator->get('Application');
			$routeMatch  = $application->getMvcEvent()->getRouteMatch();
			$router      = $application->getMvcEvent()->getRouter();
			$pages       = $this->getPagesFromConfig($configuration['navigation'][$this->getName()]);
            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
		}
		return $this->pages;
	}
}