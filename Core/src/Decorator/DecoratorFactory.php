<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Decorator;

class DecoratorFactory
{

	/**
	 * The decorator manger
	 *
	 * @var null|DecoratorPluginManager
	 */
	protected static $decoratorManager = null;

	const CELL_PREFIX = 'cell';
	const HEADER_PREFIX = 'header';
	const ROW_PREFIX = 'row';

	/**
	 *
	 * @param string $name
	 * @param array $options
	 * @return AbstractDecorator
	 */
	public static function factoryCell($name, $options) {
		$decorator = static::getPluginManager()->getInvokableClasses(self::CELL_PREFIX . $name);
		return (new \ReflectionClass($decorator))->newInstance($options);
	}

	/**
	 *
	 * @param string $name
	 * @param array $options
	 * @return AbstractDecorator
	 */
	public static function factoryRow($name, $options) {
		$decorator = static::getPluginManager()->getInvokableClasses(self::ROW_PREFIX . $name);
		return (new \ReflectionClass($decorator))->newInstance($options);
	}

	/**
	 *
	 * @param string $name
	 * @param array $options
	 * @return AbstractDecorator
	 */
	public static function factoryHeader($name, $options) {
		$decorator = static::getPluginManager()->getInvokableClasses(self::HEADER_PREFIX . $name);
		return (new \ReflectionClass($decorator))->newInstance($options);
	}

	/**
	 * Get the pattern plugin manager
	 *
	 * @return DecoratorPluginManager
	 */
	public static function getPluginManager() {
		if (static::$decoratorManager === null) {
			static::$decoratorManager = new DecoratorPluginManager();
		}
		return static::$decoratorManager;
	}

}
