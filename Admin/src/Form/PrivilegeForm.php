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


		################# parent #################
		$this->add([
			'type'=>Select::class,
			'name'=>'parent',
			'options'=>[
				'label'=>'Privilégios\Default',
				'disable_inarray_validator'=>true,
				'empty_option'=>'--Selecione--',
				'value_options'=>[
					'upload,gallery,listgallery,deletegalleryitem,file,index,listar'=>"Listar",
					'state,upload,gallery,listgallery,deletegalleryitem,file,index,listar'=>"Listar e alterar status",
					'state,upload,gallery,listgallery,deletegalleryitem,file,index,listar,editar,editar-form'=>"Listar, alterar status e Editar",
					'state,upload,gallery,listgallery,deletegalleryitem,file,index,listar,editar,create,editar-form'=>"Listar, alterar status, Editar e Criar",
					'state,upload,gallery,listgallery,deletegalleryitem,file,index,listar,editar,create,editar-form,delete'=>"Listar, alterar status, Editar, Criare e Deletar",
				]
			],
			'attributes'=>[
				'id'=>'action',
				'class'=>'form-control',
				'required'=>true,
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

		################# action #################
		$this->add([
			'type'=>Text::class,
			'name'=>'action',
			'options'=>[
				'label'=>'Privilégios Adicionais'
			],
			'attributes'=>[
				'id'=>'action',
				'class'=>'form-control',
				'placeholder'=>'Privilégios Adicionais',
				'required'=>true,
			]
		]);
		$resources=array_merge($this->getResources('invokables'),$this->getResources('factories'));
		################# controller #################
		$this->add([
			'type'=>Select::class,
			'name'=>'controller',
			'options'=>[
				'label'=>'Controller',
				'disable_inarray_validator'=>true,
				'empty_option'=>'--Selecione--',
				'value_options'=>$resources
			],
			'attributes'=>[
				'id'=>'controller',
				'class'=>'form-control',
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