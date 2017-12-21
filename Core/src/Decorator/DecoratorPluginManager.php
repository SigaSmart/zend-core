<?php
/**
 * Table ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Decorator;

class DecoratorPluginManager
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
		'cellimg' => '\Core\Decorator\Cell\Img',
		'cellbutton' => '\Core\Decorator\Cell\Button',
		'cellcheck' => '\Core\Decorator\Cell\Check',
		'cellstatus' => '\Core\Decorator\Cell\Status',
		'cellstate' => '\Core\Decorator\Cell\State',
		'cellnumber' => '\Core\Decorator\Cell\Number',
		'celltemplate' => '\Core\Decorator\Cell\Template',
		'celleditable' => '\Core\Decorator\Cell\Editable',
		'cellcallable' => '\Core\Decorator\Cell\CallableDecorator',


		'rowclass' => '\Core\Decorator\Row\ClassDecorator',
		'rowvarattr' => '\Core\Decorator\Row\VarAttr',
		'rowseparatable' => '\Core\Decorator\Row\Separatable',
		'headercheck' => '\Core\Decorator\Header\Check',
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

	public function getInvokableClasses($name) {
		return $this->invokableClasses[$name];
	}


}