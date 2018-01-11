<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Form;


use Admin\Table\ResourceTable;
use Core\Form\AbstractForm;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class ModuleForm extends AbstractForm
{

	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);
		$this->setAttribute('class','form-horizontal');
		//Add os campos abaixo voce pode usar o comando
		// zf-input-text ou zf-input-select ou zf-input-checkbox ou zf-input-radio
		################# module #################
//		$Select = $this->dbValueOptions(ResourceTable::class, ['status'=>1],['alias','name']);
//		$this->add([
//			'type'=> Select::class,
//			'name'=>'module',
//			'options'=>[
//				'disable_inarray_validator'=>true,
//				'label'=>'Modulo',
//				'empty_option'=>'--Selecione--',
//				'value_options'=>$this->getValueDb($Select)
//			],
//			'attributes'=>[
//				'id'=>'module',
//				'class'=>'form-control'
//			]
//		]);
		################# module #################
		$this->add([
			'type'=>Text::class,
			'name'=>'module',
			'options'=>[
				'label'=>'Nome do Modulo'
			],
			'attributes'=>[
				'id'=>'classe',
				'class'=>'form-control',
				'placeholder'=>'Nome do Modulo',
				'required'=>true,
			]
		]);

		################# classes #################
		$this->add([
			'type'=>Text::class,
			'name'=>'classe',
			'options'=>[
				'label'=>'Nome das classes'
			],
			'attributes'=>[
				'id'=>'classe',
				'class'=>'form-control',
				'placeholder'=>'Nome das classes',
				'required'=>false,
			]
		]);

		$this->setInputFilter($this->addInputFilter());

	}
	public function addInputFilter()
	{
		$inputFilter = new InputFilter();
		// Add validation rules for the "file" field.
		$inputFilter->add([
			'name'=>'module',
			'required'=>true,
			'filters'=>[

				[
					'name'=>StringTrim::class,
				],
				[
					'name'=>StripTags::class
				]

			],
			'validators'=>[
				[
					'name' => StringLength::class,
					'options' => [
						'max' => 100,
						'min' => 1,
						'messages' => [
							StringLength::TOO_SHORT => "Campo [Nome do modulo] Muito Curto",
							StringLength::TOO_LONG => "Campo [Nome do modulo] Muito Longo",
						],
					],
				],
				[
					'name' => NotEmpty::class,
					'options' => [
						'messages' => [NotEmpty::IS_EMPTY => "Campo [Nome do modulo] Obrigatorio"],
					],
				],
			]
		]);

		$inputFilter->add([
			'name'=>'classe',
			'required'=>false,
			'filters'=>[

				[
					'name'=>StringTrim::class,
				],
				[
					'name'=>StripTags::class
				]

			],
			'validators'=>[]
		]);
		return $inputFilter;
	}
}