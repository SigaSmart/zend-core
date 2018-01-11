<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 05/01/2018
 * Time: 16:32
 */

namespace Client;


use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{

	/**
	 * Returns configuration to merge with application configuration
	 *
	 * @return array|\Traversable
	 */
	public function getConfig()
	{
		return include __DIR__ . "/../config/module.config.php";
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
				################ Client ###################
				\Client\Model\ClientModel::class => \Client\Model\Factory\ModelFactory::class,
				\Client\Table\ClientTable::class => \Client\Table\Factory\TableFactory::class,
				\Client\Api\Model\Client::class => \Client\Api\Model\Factory\ApiModelFactory::class,
				\Client\Form\ClientForm::class => \Client\Form\Factory\FormFactory::class
			]

		];
	}
}