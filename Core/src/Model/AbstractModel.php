<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 18/12/2017
 * Time: 07:52
 */

namespace Core\Model;


use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Stdlib\ArrayObject;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\Db\RecordExists;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class AbstractModel extends ArrayObject
{

	protected $inputFilter;
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	public function __construct(ContainerInterface $container, array $input = [], $flags = self::STD_PROP_LIST, $iteratorClass = 'ArrayIterator')
	{
		parent::__construct($input, $flags, $iteratorClass);
		$this->container = $container;
	}


	public function getInputFilter(){
		return $this->inputFilter;
	}

	protected function filters(){

		return [

			[
				'name'=>StringTrim::class,
			],
			[
				'name'=>StripTags::class
			]

		];
	}

	public function StringLength($name, $max=255,$min=1){
		return[
			'name' => StringLength::class,
			'options' => [
				'max' => $max,
				'min' => $min,
				'messages' => [
					StringLength::TOO_SHORT => "Campo [{$name}] Muito Curto",
					StringLength::TOO_LONG => "Campo [{$name}] Muito Longo",
				],
			],
		];
	}

	protected function NotEmpty($name){
		return [
			'name' => NotEmpty::class,
			'options' => [
				'messages' => [NotEmpty::IS_EMPTY => "Campo [{$name}] Obrigatorio"],
			],
		];
	}

	protected function NoRecordExists(){
		$NoRecordExists = new NoRecordExists(
			[
				'table' => 'users',
				'field' => 'email',
				'adapter' => $this->container->get(AdapterInterface::class),
				'messages' =>[
					NoRecordExists::ERROR_RECORD_FOUND => 'Email Ja Existe!'
				],
			]
		);
		if($this->offsetExists('id') && $this->offsetGet('id')):
			$NoRecordExists->setExclude([
				'field' => 'id',
				'value' => $this->offsetGet('id')
			]);
		endif;
		return $NoRecordExists;

	}

	protected function RecordExists(){
        $RecordExists = new RecordExists([
			'table' => 'users',
			'field' => 'email',
			'adapter' => $this->container->get(AdapterInterface::class),
			'messages' =>[
				RecordExists::ERROR_NO_RECORD_FOUND => 'Email não Existe!'
			],
		]);
		if($this->offsetExists('id') && $this->offsetGet('id')):
			$RecordExists->setExclude([
				'field' => 'id',
				'value' => $this->offsetGet('id')
			]);
		endif;
		return $RecordExists;
	}
}