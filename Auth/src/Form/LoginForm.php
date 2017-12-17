<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/12/2017
 * Time: 21:32
 */

namespace Auth\Form;


use Core\Form\AbstractForm;

class LoginForm extends AbstractForm
{

	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);
        $this->setAttribute('action',"auth/login");
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