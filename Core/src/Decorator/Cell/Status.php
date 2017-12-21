<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 19:47
 */

namespace Core\Decorator\Cell;


use Core\Decorator\Exception\InvalidArgumentException;

class Status extends AbstractCellDecorator {

	/**
	 * Array of variable attribute for link
	 * @var array
	 */
	protected $vars;

	/**
	 * Link class
	 * @var string
	 */
	protected $class;

	/**
	 * Constructor
	 *
	 * @param array $options
	 * @throws InvalidArgumentException
	 */
	public function __construct(array $options = array()) {
		if (!isset($options['class'])) {
			throw new InvalidArgumentException('Url key in options argument required');
		}

		$this->class = $options['class'];

		if (isset($options['vars'])) {
			$this->vars = is_array($options['vars']) ? $options['vars'] : array($options['vars']);
		}
	}

	/**
	 * Rendering decorator
	 * @param string $context
	 * @return string
	 */
	public function render($context) {
		$values = array();
		if (count($this->vars)) {
			$actualRow = $this->getCell()->getActualRow();
			foreach ($this->vars as $key => $var) {
				$values[] = $actualRow[$key];
			}
		}
		$class = vsprintf($this->class, $values);
		return sprintf('<span  class="text-%s">%s</span>', $this->vars['status'][$values[0]], $context);
	}

}
