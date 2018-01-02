<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 02/01/2018
 * Time: 13:52
 */

namespace Webblog\Controller\Factory;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ControllerFactoy implements FactoryInterface
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
		return (new \ReflectionClass(sprintf("%sController", $requestedName)))->newInstance($container);
	}
}