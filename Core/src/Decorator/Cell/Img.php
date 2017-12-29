<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 19:46
 */

namespace Core\Decorator\Cell;


use Core\Decorator\Exception\InvalidArgumentException;

class Img extends AbstractCellDecorator
{

	/**
	 * Array of variables
	 * @var null | array
	 */
	protected $vars;
	protected $base;
	protected $attrs = ['class'=>'img-md'];
	protected $w = 100;
	protected $h = 100;
	private $thumbnail =false;

	/**
	 * Constructor
	 *
	 * @param array $options
	 * @throws InvalidArgumentException
	 */
	public function __construct(array $options = [])
	{
		if (!isset($options['base'])) {
			throw new InvalidArgumentException('path key in options argument requred');
		}
		$this->base = $options['base'];
		$this->vars = is_array($options['vars']) ? $options['vars'] : [$options['vars']];
		$this->attrs = is_array($options['attrs']) ? $options['attrs'] : $this->attrs;
		$this->w = isset($options['w']) ? $options['w'] : $this->w;
		$this->h = isset($options['h']) ? $options['h'] : $this->h;
		$this->thumbnail = isset($options['thumbnail']) ? $options['thumbnail'] : $this->thumbnail;

	}

	/**
	 * Rendering decorator
	 *
	 * @param string $context
	 * @return string
	 */
	public function render($context)
	{
		$values = [];
		$values[] = $this->getAttr();
		$values[] = $this->base;
		foreach ($this->vars as $var) {
			$actualRow = $this->getCell()->getActualRow();
			if (is_object($actualRow)) {
				$actualRow = $actualRow->getArrayCopy();
			}
			$values[] = $actualRow[$var];
		}
		$values[] = $this->w;
		$values[] = $this->h;
		$values[] = $this->thumbnail;

		$value = vsprintf('<img %s src="%s?name=%s&w=%s&h=%s&thumbnail=%s">', $values);

		return $value;

	}
	protected function getAttr(){
		$attrs = [];
		foreach ($this->attrs as $key=>$value):
			$attrs[] = sprintf('%s="%s"' ,$key, $value);
		endforeach;
		return implode(" ", $attrs);
	}
}