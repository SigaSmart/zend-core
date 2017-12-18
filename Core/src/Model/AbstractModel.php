<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 18/12/2017
 * Time: 07:52
 */

namespace Core\Model;


use Zend\Stdlib\ArrayObject;

class AbstractModel extends ArrayObject
{

	protected $inputFilter;

	public function __construct(array $input = [], $flags = self::STD_PROP_LIST, $iteratorClass = 'ArrayIterator')
	{
		parent::__construct($input, $flags, $iteratorClass);
	}


	public function getInputFilter(){
		return $this->inputFilter;
	}
}