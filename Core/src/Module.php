<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core;

use Core\View\Helper\FlashMsg;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;

class Module implements BootstrapListenerInterface
{
	const VERSION = '3.0.3-dev';

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
		$eventManager->attach('dispatch.error', function($event)
		{
			$exception = $event->getResult()->exception;
			if ($exception) {
				$sm = $event->getApplication()->getServiceManager();
				$serviceLog = $sm->get('prj-errorhandling');
				if($exception instanceof \Exception):
					$serviceLog->logException($exception);
				endif;
			}

			$this->finishLog = false;
		});

		$eventManager->attach('finish', function($event)
		{
			if ($this->finishLog)
			{
				$result = $event->getResult();
				$events = method_exists($result, 'getVariables') ? $result->getVariables() : false;
				$exception = isset($events['exception']) ? $events['exception'] : false;
				if ($exception) {
					$sm = $event->getApplication()->getServiceManager();
					$serviceLog = $sm->get('prj-errorhandling');
					$serviceLog->logException($exception);
				}
			}
		});

		$ViewHelperManager=$e->getApplication()->getServiceManager()->get('ViewHelperManager');
		$e->getApplication()->getServiceManager()->get('ViewHelperManager')->setFactory('FlashMsg', function($sm) use ($ViewHelperManager) {
			$viewHelper = new FlashMsg(
				$ViewHelperManager->get('FlashMessenger'),
				$ViewHelperManager->get('inlinescript'),
				$ViewHelperManager->get('HeadLink'),
				$ViewHelperManager->get('url'));
			return $viewHelper;
		});

	}
}
