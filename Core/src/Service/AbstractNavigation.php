<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/01/2018
 * Time: 12:38
 */

namespace Core\Service;


use Core\AbstractTable;
use Interop\Container\ContainerInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class AbstractNavigation extends DefaultNavigationFactory
{
	protected $configuration;

	protected $fetch;
	/**
	 * @var $Select AbstractTable
	 */
	protected $Select;

	/**
	 * @param mixed $configuration
	 *
	 * @return AbstractNavigation
	 */
	public function setConfiguration($configuration)
	{
		$this->configuration = $configuration;
		return $this;
	}


	/**
	 * @return $this
	 */
	protected function setStmt()
	{
		$this->Select->setStmt($this->Select->getSql()->prepareStatementForSqlObject($this->fetch));
		$this->Select->exec();
		return $this;
	}


	/**
	 * @param ContainerInterface $container
	 *
	 * @return array
	 * @throws \Zend\Navigation\Exception\InvalidArgumentException
	 */
	protected function getPages(ContainerInterface $container)
	{
		if (null === $this->pages) {
			if (!isset($this->configuration['navigation'])) {
				throw new \InvalidArgumentException('Could not find navigation configuration key');
			}
			if (!isset($this->configuration['navigation'][$this->getName()])) {
				throw new \InvalidArgumentException(sprintf(
					'Failed to find a navigation container by the name "%s"',
					$this->getName()
				));
			}

			$application = $container->get('Application');
			$routeMatch = $application->getMvcEvent()->getRouteMatch();
			$router = $application->getMvcEvent()->getRouter();
			$pages = $this->getPagesFromConfig($this->configuration['navigation'][$this->getName()]);
			$this->pages = $this->injectComponents($pages, $routeMatch, $router);
		}
		return $this->pages;
	}


}