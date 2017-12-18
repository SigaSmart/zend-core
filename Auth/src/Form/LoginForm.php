<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/12/2017
 * Time: 21:32
 */

namespace Auth\Form;


use Core\Form\AbstractForm;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;

class LoginForm extends AbstractForm
{

	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);
        $this->setAttribute('action',"auth/login");

        //######################## first_name #######################
		$this->add([
			'type'=> Text::class,
			'name' => 'first_name',
			'options'=>[
				'label'=>"Primeiro Nome:"
			],
			"attributes"=>[
				'id'=>"first_name",
				'class'=>'form-control validate',
				'placeholder'=>"Digite seu nome"
			]

		]);

		//######################## last_name #######################
		$this->add([
			'type'=> Text::class,
			'name' => 'last_name',
			'options'=>[
				'label'=>"Sobre Nome:"
			],
			"attributes"=>[
				'id'=>"last_name",
				'class'=>'form-control validate',
				'placeholder'=>"Sobre nome"
			]

		]);

		//######################## cover #######################
		$this->add([
			'type'=> Text::class,
			'name' => 'cover',
			'options'=>[
				'label'=>"Image:"
			],
			"attributes"=>[
				'id'=>"email",
				'class'=>'form-control validate',
				'placeholder'=>"Image"
			]

		]);

		//######################## status #######################
		$this->add([
			'type'=> Select::class,
			'name' => 'status',
			'options'=>[
				'label'=>"Status:",
				'value_options'=>[
					'1' => "Ativo",
					'2'=>'Inativo'
				]
			],
			"attributes"=>[
				'id'=>"status",
				'class'=>'form-control validate',
				'placeholder'=>"Image"
			]

		]);

		//######################## role #######################
		$this->add([
			'type'=> Select::class,
			'name' => 'role',
			'options'=>[
				'label'=>"Status:",
				'value_options'=>[
					'1' => "Admin",
					'2'=>'Quest'
				]
			],
			"attributes"=>[
				'id'=>"role",
				'class'=>'form-control validate',
				'placeholder'=>"Image"
			]

		]);

		//######################## email #######################
		$this->add([
			'type'=>'email',
			'name' => 'email',
			'options'=>[
				//'label'=>"Email"
			],
			"attributes"=>[
				'id'=>"email",
				'class'=>'form-control validate',
				'placeholder'=>"Digite seu email"
			]

		]);


		//######################## password #######################
		$this->add([
			'type'=>'password',
			'name' => 'password',
			'options'=>[
				//'label'=>"Senha"
			],
			"attributes"=>[
				'id'=>"password",
				'class'=>'form-control validate',
				'placeholder'=>"Digite sua senha"
			]

		]);
	}
}