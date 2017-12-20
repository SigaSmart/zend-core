<?php

namespace Admin\Table\Factory;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 00:34
 */
class TableFactory implements FactoryInterface
{

	/**
	 * Create an object
	 *
	 * @param  ContainerInterface $container
	 * @param  string             $requestedName
	 * @param  null|array         $options
	 *
	 * @return object
	 * @throws ServiceNotFoundException if unable to resolve the service.
	 * @throws ServiceNotCreatedException if an exception is raised when
	 *     creating a service.
	 * @throws ContainerException if any other error occurs
	 */
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		return new $requestedName($container->get(AdapterInterface::class));
	}
}