<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 27/12/2017
 * Time: 11:00
 */

namespace Core\Listener;


use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class LayoutErrorListener implements ListenerAggregateInterface
{

	/**
	 * Attach one or more listeners
	 *
	 * Implementors may add an optional $priority argument; the EventManager
	 * implementation will pass this to the aggregate.
	 *
	 * @param EventManagerInterface $events
	 * @param int                   $priority
	 *
	 * @return void
	 */
	public function attach(EventManagerInterface $events, $priority = 1)
	{
		// TODO: Implement attach() method.
	}

	/**
	 * Detach all previously attached listeners
	 *
	 * @param EventManagerInterface $events
	 *
	 * @return void
	 */
	public function detach(EventManagerInterface $events)
	{
		// TODO: Implement detach() method.
}}