<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/01/2018
 * Time: 15:01
 */

namespace Webblog\Service;


use Core\Service\AbstractNavigation;
use Interop\Container\ContainerInterface;

class Menu extends AbstractNavigation
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


			$this->configuration['navigation'][$this->getName()]['home'] = [
				'label' => "HOME",
				'route' => "web-blog",
				'controller' => "posts",
				'action' => "index",
				'params'     => ['slug' => null],
			];

			$this->configuration['navigation'][$this->getName()]['posts'] = [
				'label' => "POSTS",
				'route' => "web-blog",
				'controller' => "blog",
				'action' => "posts",
				'params'     => ['slug' => null],
			];

			$this->configuration['navigation'][$this->getName()]['abouts'] = [
				'label' => "SOBRE O PROJETO",
				'route' => "web-blog",
				'controller' => "blog",
				'action' => "abouts",
				'params'     => ['slug' => null],
			];

			$this->configuration['navigation'][$this->getName()]['contact'] = [
				'label' => "CONTATO",
				'route' => "web-blog",
				'controller' => "blog",
				'action' => "contact",
				'params'     => ['slug' => null],
			];

		}
		return parent::getPages($serviceLocator);
	}
}