<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Form;


use Admin\Table\PrivilegeTable;
use Admin\Table\ResourceTable;
use Admin\Table\RoleTable;
use Core\Form\AbstractForm;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;

class PrivilegeForm extends AbstractForm
{

	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);
		$this->setAttribute('class','form-horizontal');
		//Add os campos abaixo voce pode usar o comando
		// zf-input-text ou zf-input-select ou zf-input-checkbox ou zf-input-radio

		$Select = $this->dbValueOptions(PrivilegeTable::class, ['status'=>1]);
		################# role #################
		$this->add([
			'type'=> Select::class,
			'name'=>'parent',
			'options'=>[
				'disable_inarray_validator'=>true,
				'label'=>'Herdar',
				'empty_option'=>'--Selecione--',
				'value_options'=>$this->getValueDb($Select)
			],
			'attributes'=>[
				'id'=>'role',
				'class'=>'form-control'
			]
		]);

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

		################# alias #################
		$this->add([
			'type'=>Text::class,
			'name'=>'alias',
			'options'=>[
				'label'=>'Privilégios'
			],
			'attributes'=>[
				'id'=>'alias',
				'class'=>'form-control',
				'placeholder'=>'Privilégios',
				'required'=>true,
			]
		]);

		$Select = $this->dbValueOptions(RoleTable::class, ['status'=>1]);
		################# role #################
		$this->add([
			'type'=> Select::class,
			'name'=>'role',
			'options'=>[
				'disable_inarray_validator'=>true,
				'label'=>'Acesso',
				'empty_option'=>'--Selecione--',
				'value_options'=>$this->getValueDb($Select)
			],
			'attributes'=>[
				'id'=>'role',
				'class'=>'form-control'
			]
		]);

		$Select = $this->dbValueOptions(ResourceTable::class, ['status'=>1]);
		################# role #################
		$this->add([
			'type'=> Select::class,
			'name'=>'resource',
			'options'=>[
				'disable_inarray_validator'=>true,
				'label'=>'Modulo',
				'empty_option'=>'--Selecione--',
				'value_options'=>$this->getValueDb($Select)
			],
			'attributes'=>[
				'id'=>'resource',
				'class'=>'form-control'
			]
		]);
	}
}