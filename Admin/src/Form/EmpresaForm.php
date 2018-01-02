<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Form;


use Core\Form\AbstractForm;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;

class EmpresaForm extends AbstractForm
{

	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);
		$this->setAttribute('class','form-horizontal');

		################# tipo #################
		$this->add([
			'type'=>Hidden::class,
			'name'=>'tipo',
			'attributes'=>[
				'id'=>'tipo',
				'value'=>2
			]
		]);
		################# social #################
		$this->add([
			'type'=>Text::class,
			'name'=>'social',
			'options'=>[
				'label'=>'Razão Social'
			],
			'attributes'=>[
				'id'=>'social',
				'class'=>'form-control',
				'placeholder'=>'Razão Social',
				'required'=>true,
			]
		]);

		################# fantasia #################
		$this->add([
			'type'=>Text::class,
			'name'=>'fantasia',
			'options'=>[
				'label'=>'Nome Fantasia'
			],
			'attributes'=>[
				'id'=>'fantasia',
				'class'=>'form-control',
				'placeholder'=>'Nome Fantasia',
				'required'=>true,
			]
		]);

		################# cnpj #################
		$this->add([
			'type'=>Text::class,
			'name'=>'cnpj',
			'options'=>[
				'label'=>'Cnpj'
			],
			'attributes'=>[
				'id'=>'cnpj',
				'class'=>'form-control',
				'placeholder'=>'Cnpj',
				'required'=>true,
			]
		]);

		################# ie #################
		$this->add([
			'type'=>Text::class,
			'name'=>'ie',
			'options'=>[
				'label'=>'Inscrição Estadual'
			],
			'attributes'=>[
				'id'=>'ie',
				'class'=>'form-control',
				'placeholder'=>'Inscrição Estadual',
				'required'=>true,
				'value'=>"ISENTO",
			]
		]);

		################# phone #################
		$this->add([
			'type'=>Text::class,
			'name'=>'phone',
			'options'=>[
				'label'=>'Telefone'
			],
			'attributes'=>[
				'id'=>'phone',
				'class'=>'form-control',
				'placeholder'=>'Telefone',
				'required'=>true,
			]
		]);

		################# email #################
		$this->add([
			'type'=>Text::class,
			'name'=>'email',
			'options'=>[
				'label'=>'E-Mail'
			],
			'attributes'=>[
				'id'=>'email',
				'class'=>'form-control',
				'placeholder'=>'E-Mail',
				'required'=>true,
			]
		]);


		################# street #################
		$this->add([
			'type'=>Text::class,
			'name'=>'street',
			'options'=>[
				'label'=>'Endereço'
			],
			'attributes'=>[
				'id'=>'street',
				'class'=>'form-control',
				'placeholder'=>'Endereço',
				'required'=>true,
			]
		]);

		################# complements #################
		$this->add([
			'type'=>Text::class,
			'name'=>'complements',
			'options'=>[
				'label'=>'Complemento'
			],
			'attributes'=>[
				'id'=>'complements',
				'class'=>'form-control',
				'placeholder'=>'Complemento',
			]
		]);

		################# number #################
		$this->add([
			'type'=>Text::class,
			'name'=>'number',
			'options'=>[
				'label'=>'Numero'
			],
			'attributes'=>[
				'id'=>'number',
				'class'=>'form-control',
				'placeholder'=>'Numero',
				'required'=>true,
			]
		]);

		################# district #################
		$this->add([
			'type'=>Text::class,
			'name'=>'district',
			'options'=>[
				'label'=>'Bairro'
			],
			'attributes'=>[
				'id'=>'district',
				'class'=>'form-control',
				'placeholder'=>'Bairro',
				'required'=>true,
			]
		]);

		################# zip #################
		$this->add([
			'type'=>Text::class,
			'name'=>'zip',
			'options'=>[
				'label'=>'Cep'
			],
			'attributes'=>[
				'id'=>'zip',
				'class'=>'form-control',
				'placeholder'=>'Cep',
				'required'=>true,
			]
		]);
		################# city #################
		$this->add([
			'type'=>Text::class,
			'name'=>'city',
			'options'=>[
				'label'=>'Cidade'
			],
			'attributes'=>[
				'id'=>'city',
				'class'=>'form-control',
				'placeholder'=>'Cidade',
				'required'=>true,
			]
		]);

		################# state #################
		$this->add([
			'type'=>Text::class,
			'name'=>'state',
			'options'=>[
				'label'=>'Estado'
			],
			'attributes'=>[
				'id'=>'state',
				'class'=>'form-control',
				'placeholder'=>'Estado',
				'required'=>true,
			]
		]);

		################# country #################
		$this->add([
			'type'=>Text::class,
			'name'=>'country',
			'options'=>[
				'label'=>'Pais'
			],
			'attributes'=>[
				'id'=>'country',
				'class'=>'form-control',
				'placeholder'=>'Pais',
				'required'=>true,
				'value'=>"BRASIL",
			]
		]);

		################# description #################
		$this->add([
			'type'=>Textarea::class,
			'name'=>'description',
			'options'=>[
				'label'=>'Descrição'
			],
			'attributes'=>[
				'id'=>'description',
				'class'=>'form-control',
				'placeholder'=>'Descrição',
			]
		]);

		################# cover #################
		$this->add([
			'type'=>Hidden::class,
			'name'=>'cover',
			'attributes'=>[
				'id'=>'cover'
			]
		]);


	}
}