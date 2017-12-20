<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Decorator\Condition;

use Zend\ServiceManager\AbstractPluginManager;

class ConditionPluginManager extends AbstractPluginManager
{

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = array(
        'equal' => '\Core\Decorator\Condition\Plugin\Equal',
        'notequal' => '\Core\Decorator\Condition\Plugin\NotEqual',
        'between' => '\Core\Decorator\Condition\Plugin\Between',
        'greaterthan' => '\Core\Decorator\Condition\Plugin\GreaterThan',
        'lesserthan' => '\Core\Decorator\Condition\Plugin\LesserThan',


    );

    /**
     * Don't share plugin by default
     *
     * @var bool
     */
    protected $shareByDefault = false;


    /**
     * See AbstractPluginManager
     *
     * @throws \DomainException
     * @param mixed $plugin
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AbstractCondition) {
            return;
        }
        throw new \DomainException('Invalid Condition Implementation');
    }
}
