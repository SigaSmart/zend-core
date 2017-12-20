<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Decorator;

use Zend\ServiceManager\AbstractPluginManager;

class DecoratorPluginManager extends AbstractPluginManager
{

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = array(

        'cellattr' => '\Core\Decorator\Cell\AttrDecorator',
        'cellvarattr' => '\Core\Decorator\Cell\VarAttrDecorator',
        'cellclass' => '\Core\Decorator\Cell\ClassDecorator',
        'cellicon' => '\Core\Decorator\Cell\Icon',
        'cellmapper' => '\Core\Decorator\Cell\Mapper',
        'celllink' => '\Core\Decorator\Cell\Link',
        'celltemplate' => '\Core\Decorator\Cell\Template',
        'celleditable' => '\Core\Decorator\Cell\Editable',
        'cellcallable' => '\Core\Decorator\Cell\CallableDecorator',


        'rowclass' => '\Core\Decorator\Row\ClassDecorator',
        'rowvarattr' => '\Core\Decorator\Row\VarAttr',
        'rowseparatable' => '\Core\Decorator\Row\Separatable',
    );

    /**
     * Don't share header by default
     *
     * @var bool
     */
    protected $shareByDefault = false;

    /**
     * @param mixed $plugin
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AbstractDecorator) {
            return;
        }
        throw new \DomainException('Invalid Decorator Implementation');
    }
}
