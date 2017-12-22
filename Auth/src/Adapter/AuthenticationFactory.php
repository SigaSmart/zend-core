<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Auth\Adapter;


use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\AdapterInterface;
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