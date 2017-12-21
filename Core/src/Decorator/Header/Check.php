<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 19:49
 */

namespace Core\Decorator\Header;


class Check extends AbstractHeaderDecorator
{

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
	}

	/**
	 * Rendering decorator
	 * @param string $context
	 * @return string
	 */
	public function render($context="check-all")
	{
		return sprintf('<input style="margin-left: 10px;" type="checkbox" class="pull-left icheck" id="%s">', $context);
	}
}
