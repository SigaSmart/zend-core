<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 20:34
 */

namespace Core\Decorator\Cell;


class State extends AbstractCellDecorator
{

	/**
	 * Array of options mapping
	 * @var array
	 */
	protected $options;


	/**
	 * Constructor
	 * @param array $options
	 * @throws InvalidArgumentException
	 */
	public function __construct(array $options = array())
	{
		if (count($options) == 0) {
			throw new InvalidArgumentException('Array is empty');
		}

		$this->options = $options;
	}

	/**
	 * Rendering decorator
	 * @param string $context
	 * @return string
	 */
	public function render($context)
	{
		$class = (isset($this->options['class'][$context])) ? $this->options['class'][$context] : $context;
		$value = (isset($this->options['value'][$context])) ? $this->options['value'][$context] : $context;
		return sprintf('<span  class="text-%s">%s</span>', $class,$value);
	}
}
