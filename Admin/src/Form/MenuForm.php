<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Form;


use Admin\Table\MenuTable;
use Admin\Table\ResourceTable;
use Admin\Table\RoleTable;
use Core\Form\AbstractForm;
use Zend\Db\Sql\Predicate\IsNull;
use Zend\Form\Element\Select as SelectElement;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;

class MenuForm extends AbstractForm
{

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
		################# icone #################
		$this->add([
			'type'=>Text::class,
			'name'=>'icone',
			'options'=>[
				'label'=>'Icone'
			],
			'attributes'=>[
				'id'=>'icone',
				'class'=>'form-control',
				'placeholder'=>'Icone',
			]
		]);
		$Select = $this->dbValueOptions(ResourceTable::class, ['status'=>1]);
		################# role #################
		$this->add([
			'type'=> SelectElement::class,
			'name'=>'route',
			'options'=>[
				'disable_inarray_validator'=>true,
				'label'=>'Rota',
				'empty_option'=>'--Selecione--',
				'value_options'=>$this->getValueDb($Select)
			],
			'attributes'=>[
				'id'=>'route',
				'class'=>'form-control'
			]
		]);

		################# controller #################
		$this->add([
			'type'=>Text::class,
			'name'=>'controller',
			'options'=>[
				'label'=>'Controller'
			],
			'attributes'=>[
				'id'=>'route',
				'class'=>'form-control',
				'placeholder'=>'Controller',
			]
		]);

		################# action #################
		$this->add([
			'type'=>Text::class,
			'name'=>'action',
			'options'=>[
				'label'=>'Ação'
			],
			'attributes'=>[
				'id'=>'route',
				'class'=>'form-control',
				'placeholder'=>'action',
			]
		]);

		################# icone #################
		$this->add([
			'type'=>Text::class,
			'name'=>'icone',
			'options'=>[
				'label'=>'Icone'
			],
			'attributes'=>[
				'id'=>'route',
				'class'=>'form-control',
				'placeholder'=>'Icone, Usado somentee no menu principal',
			]
		]);

		################# description #################
		$this->add([
			'type'=>Text::class,
			'name'=>'description',
			'options'=>[
				'label'=>'Dica de tela'
			],
			'attributes'=>[
				'id'=>'route',
				'class'=>'form-control',
				'placeholder'=>'Dica de tela',
			]
		]);

		$Select = $this->dbValueOptions(MenuTable::class, ['status'=>1]);
		$Select->where(new IsNull('parent'));
		################# parent #################
		$this->add([
			'type'=> SelectElement::class,
			'name'=>'parent',
			'options'=>[
				'disable_inarray_validator'=>true,
				'label'=>'Menu Principal',
				'empty_option'=>'--Selecione--',
				'value_options'=>$this->getValueDb($Select)
			],
			'attributes'=>[
				'id'=>'parent',
				'class'=>'form-control'
			]
		]);

		$resources=array_merge($this->getResources('invokables'),$this->getResources('factories'));
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
				'class'=>'form-control',
				'required'=>true,
			]
		]);

		$Select = $this->dbValueOptions(RoleTable::class, ['status'=>1]);
		################# role #################
		$this->add([
			'type'=> SelectElement::class,
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

		$Select = $this->dbValueOptions(MenuTable::class, ['status'=>1]);
		################# role #################
		$this->add([
			'type'=> SelectElement::class,
			'name'=>'ordem',
			'options'=>[
				'disable_inarray_validator'=>true,
				'label'=>'Ordem',
				'empty_option'=>'--Selecione--',
				'value_options'=>$this->getValueDb($Select)
			],
			'attributes'=>[
				'id'=>'ordem',
				'class'=>'form-control'
			]
		]);
	}
}