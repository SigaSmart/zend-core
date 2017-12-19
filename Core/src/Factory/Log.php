<?php

namespace Core\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

use Zend\Log\Writer\Stream as LogStream;
use Zend\Log\Logger as LogLogger;

class Log implements FactoryInterface
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
		$filename = 'log_' . date('d') . '_' . date('F') . '_' . date('Y') . '.log';
		$logFile = './data/logs/' . $filename;

		$logger = new LogLogger();
		$writer = new LogStream($logFile);
		$logger->addWriter($writer);

		return $logger;
	}
}