<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Decorator\Condition;

class ConditionFactory
{
	/**
	 * The decorator manger
	 *
	 * @var null| ConditionPluginManager
	 */
	protected static $conditionManager = null;

	/**
	 *
	 * @param string $name
	 * @param array $options
	 * @return AbstractCondition
	 */
	public static function factory($name, $options)
	{
		$decorator = static::getPluginManager()->getInvokableClasses($name);
		return (new \ReflectionClass($decorator))->newInstance($options);
	}

	/**
	 * Get the condition plugin manager
	 *
	 * @return ConditionPluginManager
	 */
	public static function getPluginManager()
	{
		if (static::$conditionManager === null) {
			static::$conditionManager = new ConditionPluginManager();
		}
		return static::$conditionManager;
	}
}
