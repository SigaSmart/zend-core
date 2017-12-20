<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Decorator\Cell;

use Core\Decorator\AbstractDecorator;
use Core\Decorator\DataAccessInterface;

abstract class AbstractCellDecorator extends AbstractDecorator implements DataAccessInterface
{

    /**
     * Get cell object
     * @var \Core\Cell
     */
    protected $cell;

    /**
     *
     * @return \Core\Cell
     */
    public function getCell()
    {
        return $this->cell;
    }

    /**
     *
     * @param \Core\Cell $cell
     * @return $this
     */
    public function setCell($cell)
    {
        $this->cell = $cell;
        return $this;
    }


    /**
     * Actual row data
     *
     * @return array
     */
    public function getActualRow()
    {
        return $this->getCell()->getActualRow();
    }
}
