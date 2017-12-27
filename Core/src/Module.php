<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core;

use Core\Factory\NavigationFactory;
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
use Zend\ServiceManager\Factory\InvokableFactory;

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
		$serviceManager = $e->getApplication()->getServiceManager();

		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
		$eventManager = $e->getApplication()->getEventManager();
//		$eventManager->attach('dispatch.error', function($event)
//		{
//			$exception = $event->getResult()->exception;
//			if ($exception) {
//				$sm = $event->getApplication()->getServiceManager();
//				$serviceLog = $sm->get('prj-errorhandling');
//				if($exception instanceof \Exception):
//					$serviceLog->logException($exception);
//				endif;
//			}
//
//			$this->finishLog = false;
//		});

//		$eventManager->attach('finish', function($event)
//		{
//			if ($this->finishLog)
//			{
//				$result = $event->getResult();
//				$events = method_exists($result, 'getVariables') ? $result->getVariables() : false;
//				$exception = isset($events['exception']) ? $events['exception'] : false;
//				if ($exception) {
//					$sm = $event->getApplication()->getServiceManager();
//					$serviceLog = $sm->get('prj-errorhandling');
//					$serviceLog->logException($exception);
//				}
//			}
//		});

		$e->getApplication()
			->getEventManager()
				->getSharedManager()
					->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
						$controller      = $e->getTarget();
						$controllerClass = get_class($controller);
						$moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
						$config          = $e->getApplication()->getServiceManager()->get('config');
						if (isset($config['module_layouts'][$moduleNamespace])) {
							$controller->layout($config['module_layouts'][$moduleNamespace]);
						}

		}, 100);

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
