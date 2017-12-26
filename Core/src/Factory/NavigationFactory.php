<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 26/12/2017
 * Time: 15:12
 */

namespace Core\Factory;


use Core\View\Helper\NavigationHelper;
use Interop\Container\ContainerInterface;
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
		return new NavigationHelper($container);
	}
}