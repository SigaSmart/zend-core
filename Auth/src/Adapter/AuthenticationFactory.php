<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/12/2017
 * Time: 19:20
 */

namespace Auth\Adapter;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as Adapter;

class AuthenticationFactory implements FactoryInterface
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
		// The status field value of an account is not equal to "compromised"
		$authenticate = new Adapter(
			$container->get(AdapterInterface::class),
			'users',
			'email',
			'password',
			'MD5(?) AND status = "1"'
		);
		$dbAthenticate = new AuthenticationService();
		$dbAthenticate->setAdapter($authenticate);
		$dbAthenticate->setStorage(new AuthStorage());

		return new Authentication($dbAthenticate);
	}
}