<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Auth;

use Auth\Adapter\Authentication;
use Auth\Adapter\AuthenticationFactory;
use Auth\Adapter\Company;
use Auth\Adapter\Logado;
use Auth\Form\Factory\FormFactory;
use Auth\Form\LoginForm;
use Auth\Model\Factory\LoginModelFactory;
use Auth\Model\LoginModel;
use Auth\Table\Factory\LoginTableFactory;
use Auth\Table\Factory\TableFactory;
use Auth\Table\LoginTable;
use Interop\Container\ContainerInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ServiceProviderInterface
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to
	 * seed such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getServiceConfig()
	{
		return [
			'factories'=>[
				Authentication::class =>AuthenticationFactory::class,

				LoginForm::class => FormFactory::class,

				LoginModel::class => LoginModelFactory::class,

				LoginTable::class => LoginTableFactory::class,

				Company::class => TableFactory::class,

				Logado::class => TableFactory::class,
			]

		];
	}
}
