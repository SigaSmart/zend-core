<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 03/01/2018
 * Time: 11:43
 */

namespace Webblog\Service\Factory;


use Interop\Container\ContainerInterface;
use Webblog\Service\Categorie;
use Zend\ServiceManager\Factory\FactoryInterface;

class NavigationFactory implements FactoryInterface
{

	/**
	 * Create an object
	 *
	 * @param  ContainerInterface $container
	 * @param  string             $requestedName
	 * @param  null|array         $options
	 *
	 * @return object
	 */
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$navigation = new $requestedName();
		return $navigation->createService($container);
	}
}