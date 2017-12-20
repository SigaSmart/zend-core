<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Params;

use Core\AbstractCommon;
use Core\Config;

abstract class AbstractAdapter extends AbstractCommon
{

    /**
     * Get configuration of table
     *
     * @return \Core\Options\ModuleOptions
     */
    public function getOptions()
    {
        return $this->getTable()->getOptions();
    }
}
