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

	protected function NoRecordExists($table="users",$field="email",$campo="Email"){
		$NoRecordExists = new NoRecordExists(
			[
				'table' => $table,
				'field' => $field,
				'adapter' => $this->container->get(AdapterInterface::class),
				'messages' =>[
					NoRecordExists::ERROR_RECORD_FOUND => "{$campo} Ja Existe!"
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

	protected function RecordExists($table="users",$field="email",$campo="Email"){
		$RecordExists = new RecordExists([
			'table' => $table,
			'field' => $field,
			'adapter' => $this->container->get(AdapterInterface::class),
			'messages' =>[
				RecordExists::ERROR_NO_RECORD_FOUND => "{$campo} não Existe!"
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

	// This method creates input filter (used for form filtering/validation).
	protected function ImageFilter()
	{
		// Add validation rules for the "file" field.
		$inputFilter=[
			'type'     => 'Zend\InputFilter\FileInput',
			'name'     => 'image',
			'required' => true,
			'validators' => [
				['name'    => 'FileUploadFile'],
				[
					'name'    => 'FileMimeType',
					'options' => [
						'mimeType'  => $this->getMimiType()
					]
				],
				['name'    => 'FileIsImage'],
				[
					'name'    => 'FileImageSize',
					'options' => [
						'minWidth'  => 128,
						'minHeight' => 128,
						'maxWidth'  => 4096,
						'maxHeight' => 4096
					]
				],
			],
			'filters'  => [
				[
					'name' => 'FileRenameUpload',
					'options' => [
						'target'=>sprintf("%s/upload/images",$this->container->get('request')->getServer('DOCUMENT_ROOT')),
						'useUploadName'=>true,
						'useUploadExtension'=>true,
						'overwrite'=>true,
						'randomize'=>false
					]
				]
			],
		];
		return $inputFilter;
	}

	// This method creates input filter (used for form filtering/validation).
	protected function FileFilter()
	{
		// Add validation rules for the "file" field.
		$inputFilter=[
			'type'     => 'Zend\InputFilter\FileInput',
			'name'     => 'file',
			'required' => true,
			'validators' => [
				['name'    => 'FileUploadFile'],
				[
					'name'    => 'FileMimeType',
					'options' => [
						'mimeType'  => $this->getMimiType('ext-ms-oficce')
					]
				],
				['name'    => 'FileIsImage'],
				[
					'name'    => 'FileImageSize',
					'options' => [
						'minWidth'  => 128,
						'minHeight' => 128,
						'maxWidth'  => 4096,
						'maxHeight' => 4096
					]
				],
			],
			'filters'  => [
				[
					'name' => 'FileRenameUpload',
					'options' => [
						'target'=>sprintf("%s/upload/files",$this->container->get('request')->getServer('DOCUMENT_ROOT')),
						'useUploadName'=>true,
						'useUploadExtension'=>true,
						'overwrite'=>true,
						'randomize'=>false
					]
				]
			],
		];
		return $inputFilter;
	}

	protected function getMimiType($Types = 'ext-image-min'){
		$MimiType=[];
		$Config = $this->container->get("Config");
		$mime_types_custom =$Config['mime_types_custom'];
		$mime_types = $Config['mime_types'];
		if(isset($mime_types_custom[$Types])):
			foreach ($mime_types_custom[$Types] as $type):
				$MimiType[] = $mime_types[$type];
			endforeach;
		endif;
		return $MimiType;

	}
}