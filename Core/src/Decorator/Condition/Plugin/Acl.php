<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Decorator\Condition\Plugin;

use Core\Decorator\Condition\AbstractCondition;

class Acl extends AbstractCondition
{

	/**
	 * @var \Core\Acl
	 */
	protected $acl;
	/**
	 * nivel acesso
	 * @var string
	 */
	protected $role;
    /**
     * Name of column
     * @var string
     */
    protected $controller;

    /**
     * List of values to compare
     * @var string
     */
    protected $action;

    /**
     *
     * @param array $options
     */
    public function __construct($options)
    {
		$this->acl = $options['acl'];
        $this->role = $options['role'];
        $this->controller = $options['params']['controller'];
        $this->action = isset($options['action']) ? $options['action'] : $options['params']['action'];
    }

    /**
     * Check if the condition is valid
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->acl->isAllowed($this->role,$this->controller, $this->action);

    }
}
