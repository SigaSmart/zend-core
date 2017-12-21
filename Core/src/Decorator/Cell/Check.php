<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 19:45
 */

namespace Core\Decorator\Cell;


class Check extends AbstractCellDecorator
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
	public function render($context)
	{
		return sprintf('<input name="id[%s]" type="checkbox" class="check_acao check icheck" id="%s" value="%s">', $context, $context, $context);
	}
}