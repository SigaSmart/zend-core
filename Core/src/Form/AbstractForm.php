<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/12/2017
 * Time: 21:13
 */

namespace Core\Form;

use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class AbstractForm extends Form
{
	protected $container;
	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);

		if(isset($options['container'])):
			$this->container = $options['container'];
		endif;

		//######################## id #######################
		$this->add([
			'type'=>Hidden::class,
			'name' => 'id',
			"attributes"=>[
				'id'=>"id"
			]

		]);


		//######################## empresa #######################
		$this->add([
			'type'=>Hidden::class,
			'name' => 'empresa',
			"attributes"=>[
				'id'=>"empresa"
			]

		]);

		//######################## created_at #######################
		$this->add([
			'type'=>Text::class,
			'name' => 'created_at',
			'options'=>[
				'label'=>"Criado em:"
			],
			"attributes"=>[
				'id'=>"created_at",
				'class'=>'form-control validate date',
				'placeholder'=>"00/00/0000",
				'readonly'=>true,
				'value' => date("d/m/Y")
			]

		]);


		//######################## updated_at #######################
		$this->add([
			'type'=>Text::class,
			'name' => 'updated_at',
			'options'=>[
				'label'=>"Atualizado em:"
			],
			"attributes"=>[
				'id'=>"updated_at",
				'class'=>'form-control validate datetime',
				'placeholder'=>"00/00/0000 00:00",
				'readonly'=>true,
				'value' => date("d/m/Y H:i")
			]

		]);

       //######################## submit #######################
		$this->add([
			'type'=>Submit::class,
			'name' => 'submit',
			"attributes"=>[
				'id'=>"button",
				'class'=>'btn btn-primary btn-block btn-flat btn-block',
				'value'=>"Atualizar Cadastro"
			]
		]);

	}

}