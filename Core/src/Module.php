<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core;

use Auth\Adapter\Authentication;
use Auth\Adapter\Company;
use Auth\Adapter\Logado;
use Core\Factory\AclFactory;
use Core\Factory\NavigationFactory;
use Core\Listener\LayoutListener;
use Core\Service\ImageManager;
use Core\Service\PHPThumb;
use Core\View\Helper\FlashMsg;
use Core\View\Helper\ICheckHelper;
use Core\View\Helper\RouteHelper;
use Core\View\Helper\ZfForm;
use Core\View\Helper\ZfTable;
use Interop\Container\ContainerInterface;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\View\HelperPluginManager;

class Module implements BootstrapListenerInterface, ViewHelperProviderInterface, ServiceProviderInterface
{
	const VERSION = '3.0.3-dev';
	const SIS = 'SIGA-SMART';

	public function getConfig()
	{
		return include __DIR__ . '/../config/module.config.php';
	}

	protected $finishLog = true;


	/**
	 * Listen to the bootstrap event
	 *
	 * @param EventInterface $e
	 *
	 * @return array
	 */
	public function onBootstrap(EventInterface $e)
	{

		$eventManager = $e->getApplication()->getEventManager();
		//$serviceManager = $e->getApplication()->getServiceManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);


		$moduleRouteListener->attach($eventManager);
		$eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), 0);

		$eventManager->getSharedManager()
			->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
				(new LayoutListener($e));
			}, 100);
	}

	/**
	 * @param MvcEvent $e
	 */
	public function onDispatch(MvcEvent $e)
	{
		$app = $e->getApplication()->getServiceManager();
		/**
		 * @var $Authenticate Authentication
		 */
		$Authenticate    	= $app->get(Authentication::class);

		if($Authenticate->hasIdentity()):
			$Identity = $Authenticate->getIdentity();
			/**
			 * @var $Logado Logado
			 */
			$Logado    			= $app->get(Logado::class);
			$UserLogagado 		= $Logado->user($Identity->id);
			/**
			 * @var $Company Company
			 */
			$Company = $app->get(Company::class);
			$Company->matriz($Identity->empresa);
			$UserLogagado->restrito = $Company->getRestrito();
			$Authenticate->getStorage()->write($UserLogagado);
		endif;
	}
	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to
	 * seed such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getViewHelperConfig()
	{
		return [
			'factories'=>[
				"FlashMsg" =>function(ContainerInterface $container){
					$ViewHelperManager=$container->get('ViewHelperManager');
					$viewHelper = new FlashMsg(
						$ViewHelperManager->get('FlashMessenger'),
						$ViewHelperManager->get('inlinescript'),
						$ViewHelperManager->get('HeadLink'),
						$ViewHelperManager->get('url'));
					return $viewHelper;
				},
				"Route" =>function(ContainerInterface $container){
					$Route = new RouteHelper($container);
					return $Route;
				},
				"ZfTable" =>function(ContainerInterface $container){
					$ViewHelperManager=$container->get('ViewHelperManager');
					$ZfTable = new ZfTable(
						$ViewHelperManager->get('inlinescript'),
						$ViewHelperManager->get('HeadLink'),
						$ViewHelperManager->get('url'));
					return $ZfTable;
				},
				"ZfForm" =>function(ContainerInterface $container){
					$ViewHelperManager=$container->get('ViewHelperManager');
					$ZfTable = new ZfForm(
						$ViewHelperManager->get('inlinescript'),
						$ViewHelperManager->get('HeadLink'),
						$ViewHelperManager->get('url'));
					return $ZfTable;
				},
				"ICheck" =>function(ContainerInterface $container){
					$ViewHelperManager=$container->get('ViewHelperManager');
					$ICheckHelper = new ICheckHelper(
						$ViewHelperManager->get('inlinescript'),
						$ViewHelperManager->get('HeadLink'),
						$ViewHelperManager->get('url'));
					return $ICheckHelper;
				},
				"Acl" =>AclFactory::class

			],
			'invokables'=>[
				'phpthumb' => PHPThumb::class,

			]
		];
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
				ImageManager::class => InvokableFactory::class,
				'Navigation'=>NavigationFactory::class
			]
		];
	}
}
