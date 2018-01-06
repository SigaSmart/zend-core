<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/01/2018
 * Time: 11:35
 */

namespace Webblog\Service;


use Blog\Table\CategorieTable;
use Core\Service\AbstractNavigation;
use Interop\Container\ContainerInterface;
use Zend\Db\Sql\Predicate\IsNull;
use Zend\Db\Sql\Predicate\Operator;

class Categorie extends AbstractNavigation
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

			$this->Select = $serviceLocator->get(CategorieTable::class);
			$this->fetch= $this->Select->getSelect()->where(new IsNull('parent'));
			$this->setStmt();
			if($this->Select->getResultSet()->count()):
				$Datas = $this->Select->getResultSet()->toArray();
				foreach($Datas as $key=>$row)
				{
					$Pages=[];
					$this->fetch= $this->Select->getSelect()->where(new Operator('parent',Operator::OP_EQ, $row['id']));
					$this->fetch->where(['status'=>1]);
					$this->setStmt();
					if($this->Select->getResultSet()->count()):
						$SubDatas = $this->Select->getResultSet()->toArray();
						foreach($SubDatas as $subrow)
						{
							$Pages[]= [
								'label' => $subrow['name'],
								'route' => "web-blog",
								'controller' => "blog",
								'action' => "posts",
								//'slug' => $subrow['alias'],
								'params'     => ['slug' => $subrow['alias']],
							];
						}
					endif;
					$this->configuration['navigation'][$this->getName()][$row['name']] = [
						'label' => $row['name'],
						'route' => "web-blog",
						'controller' => "blog",
						'action' => "posts",
						//'slug' => $row['alias'],
						'params'     => ['slug' => $row['alias']],
						'pages'=>$Pages
					];
				}
			endif;

		}
		return parent::getPages($serviceLocator);
	}
}