<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Decorator;

interface DecoratorInterface
{

    /**
     * @param $render
     * @return mixed
     */
    public function render($render);
}
