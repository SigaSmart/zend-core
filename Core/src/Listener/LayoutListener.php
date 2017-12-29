<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 27/12/2017
 * Time: 11:00
 */

namespace Core\Listener;


use Zend\EventManager\Event;

class LayoutListener extends Event
{
	public function __construct($event)
	{
		$config = $event->getApplication()->getServiceManager()->get('config');
		$layout_map = $config['module_layouts'];
		$controller = $event->getTarget();

		if (!$controller) {
			$controller = $event->getRouteMatch()->getParam('controller');
		}
		//Pegar o layout pelo controller
		$controller_class = get_class($controller);
		//Pega pelo namespace
		$module_namespace = substr($controller_class, 0, strpos($controller_class, '\\'));
		$controller_class = strtolower(str_replace("\\", "_", $controller_class));
		//Pela action
		$action = $event->getRouteMatch()->getParam('action');
		//d(array($layout_map,$module_namespace,$controller_class,$action));

		if (array_key_exists($module_namespace, $layout_map)) {
			$controller->layout(strtolower($layout_map[$module_namespace]));
		}

		if (array_key_exists(strtolower($controller_class), $layout_map)) {
			$controller->layout(strtolower($layout_map[$controller_class]));
		}

		if (array_key_exists(strtolower($action), $layout_map)) {
			$controller->layout(strtolower($layout_map[$action]));
		}
		$id = $event->getRouteMatch()->getParam('id', null);
		if (!is_null($id)) {

		}
	}

}