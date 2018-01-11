<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Decorator\Cell;

use Core\Decorator\Exception;

class Pad extends AbstractCellDecorator
{

    /**
     * Array of variable attribute for link
     * @var array
     */
    protected $pad;

    /**
     * Link dec
     * @var int
     */
    protected $length;

	/**
	 * @var $string string
	 */
	protected $string;


	/**
     * Constructor
     *
     * @param array $options
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(array $options = array())
    {

       $this->pad = isset($options['pad'])?$options['pad']:STR_PAD_LEFT;
       $this->length = isset($options['length'])?$options['length']:2;
       $this->string = isset($options['string'])?$options['string']:"0";

    }

    /**
     * Rendering decorator
     * @param string $context
     * @return string
     */
    public function render($context)
    {
        return str_pad($context,$this->length, $this->string, $this->pad);
    }
}
