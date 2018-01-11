<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Form;


use Core\Form\AbstractForm;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;

class ResourceForm extends AbstractForm
{

	/**
	 * ResourceForm constructor.
	 *
	 * @param null  $name
	 * @param array $options
	 */
	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);
		$this->setAttribute('class','form-horizontal');
		//Add os campos abaixo voce pode usar o comando
		// zf-input-text ou zf-input-select ou zf-input-checkbox ou zf-input-radio
		################# name #################
		$this->add([
			'type'=>Text::class,
			'name'=>'name',
			'options'=>[
				'label'=>'Nome\Descrição'
			],
			'attributes'=>[
				'id'=>'name',
				'class'=>'form-control',
				'placeholder'=>'Nome\Descrição',
				'required'=>true,
			]
		]);
		$invokables = $this->getResources('invokables');
		$factories = $this->getResources('factories');
		$resources=[];
		if($invokables):
			foreach ($invokables as $key => $value) {
				$resources[$key]=$key;
			}
		endif;
		if($factories):
			foreach ($factories as $key => $value) {
				$resources[$key]=$key;
			}
		endif;
		################# alias #################
		$this->add([
			'type'=>Select::class,
			'name'=>'alias',
			'options'=>[
				'label'=>'Nome real',
				'disable_inarray_validator'=>true,
				'empty_option'=>'--Selecione--',
				'value_options'=>$resources
			],
			'attributes'=>[
				'id'=>'alias',
				'class'=>'form-control'
			]
		]);


		################# route  #################
		$this->add([
			'type'=>Text::class,
			'name'=>'route',
			'options'=>[
				'label'=>'Rota'
			],
			'attributes'=>[
				'id'=>'route',
				'class'=>'form-control',
				'placeholder'=>'route',
				'required'=>true,
			]
		]);
	}


}