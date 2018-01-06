<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 02/01/2018
 * Time: 13:35
 */

namespace Webblog;


use Webblog\Form\ContactForm;
use Webblog\Form\Factory\FormFactory;
use Webblog\Service\Categorie;
use Webblog\Service\Factory\CategorieFactory;
use Webblog\Service\Factory\NavigationFactory;
use Webblog\Service\Menu;
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
		//factories
			'factories'=>[
				Categorie::class=>NavigationFactory::class,
				Menu::class=>NavigationFactory::class,
				ContactForm::class => FormFactory::class

			]
			//invokables
		];
	}
}