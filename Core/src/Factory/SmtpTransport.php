<?php

namespace Core\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Mail\Transport\SmtpOptions,
	Zend\Mail\Transport\Smtp;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class SmtpTransport implements FactoryInterface
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
		$config = $container->get('config');

		if (isset($config['PRJMail']['transport']['smtpOptions'])) {
			$valuesOptions = $config['PRJMail']['transport']['smtpOptions'];
			$transportSslOptions = $config['PRJMail']['transport']['transportSsl'];

			if ($transportSslOptions['use_ssl'])
				$valuesOptions['connection_config']['ssl'] = $transportSslOptions['connection_type'];

			$smtpOptions = new SmtpOptions($valuesOptions);
			$transport = new Smtp($smtpOptions);
		} else {
			throw new \Exception('Você precisa configurar o STMP Options no module.config.php');
		}

		return $transport;
	}
}