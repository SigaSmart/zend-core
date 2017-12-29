<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Form;


use Admin\Table\RoleTable;
use Auth\Adapter\Authentication;
use Core\Form\AbstractForm;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;

class UserForm extends AbstractForm
{

	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);
		$this->setAttribute('class','form-horizontal');
		//Add os campos abaixo voce pode usar o comando
		// zf-input-text ou zf-input-select ou zf-input-checkbox ou zf-input-radio
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
				'placeholder'=>"Digite seu nome",
				'ico'=>"glyphicon glyphicon-user",
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
				'placeholder'=>"Sobre nome",
				'ico'=>"glyphicon glyphicon-user",
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
				'placeholder'=>"Image",
				'ico'=>"glyphicon glyphicon-image",
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
		$this->user();
		$Select = $this->dbValueOptions(RoleTable::class, ['status'=>1]);
		if($this->users):
		 $Select->where(new Operator("id", Operator::OP_GTE,$this->users->access));
		endif;
		//######################## access #######################
		$this->add([
			'type'=> Select::class,
			'name' => 'access',
			'options'=>[
				'label'=>"Nivel De Acesso:",
				'disable_inarray_validator'=>true,
				'empty_option'=>'--Selecione--',
				'value_options'=>$this->getValueDb($Select)
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
				'label'=>"Email"
			],
			"attributes"=>[
				'id'=>"email",
				'class'=>'form-control validate',
				'placeholder'=>"Digite seu email",
				'ico'=>'glyphicon glyphicon-envelope'
			]

		]);


		//######################## password #######################
		$this->add([
			'type'=>'password',
			'name' => 'password',
			'options'=>[
				'label'=>"Senha"
			],
			"attributes"=>[
				'id'=>"password",
				'class'=>'form-control validate',
				'placeholder'=>"Digite sua senha",
				'ico'=>'glyphicon glyphicon-lock'
			]

		]);
	}
}