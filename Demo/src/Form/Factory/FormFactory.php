<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Demo\Form\Factory;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class FormFactory implements FactoryInterface
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
		return new $requestedName($container);
	}
}