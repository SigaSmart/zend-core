<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Decorator\Header;

use Core\Decorator\AbstractDecorator;

abstract class AbstractHeaderDecorator extends AbstractDecorator
{

    /**
     * Header object
     * @var \Core\Header
     */
    protected $header;

    /**
     *
     * @return \Core\Header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     *
     * @param \Core\Header $header
     * @return \Core\Decorator\Header\AbstractHeaderDecorator
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }
}
