<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Form;


use Admin\Table\RoleTable;
use Core\Form\AbstractForm;
use Zend\Db\Sql\Predicate\IsNull;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;

class RoleForm extends AbstractForm
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
				'required'=>true
			]
		]);

		  ################# icone #################
		$this->add([
			'type'=> Select::class,
			'name'=>'parent',
			'options'=>[
				'disable_inarray_validator'=>true,
				'label'=>'Herdar\Acesso',
				'empty_option'=>'--Selecione--',
				'value_options'=>[]
			],
			'attributes'=>[
				'id'=>'parent',
				'class'=>'form-control'
			]
		]);
		$ViewHelperManager=$this->container->get('ViewHelperManager');
		$Select = $this->dbValueOptions(RoleTable::class, ['status'=>1]);
		if($ViewHelperManager->get('Route')->getId()):
			$Select->where(new Operator("id", Operator::OP_GT,$ViewHelperManager->get('Route')->getId()));
		endif;
		$this->get('parent')->setOptions(['value_options'=>$this->getValueDb($Select)]);
		################# icone #################
		$this->add([
			'type'=> Select::class,
			'name'=>'is_admin',
			'options'=>[
				'disable_inarray_validator'=>true,
				'label'=>'Todos os privilégios',
				'empty_option'=>'--Selecione--',
				'value_options'=>[
					1=>'Sim'
				]
			],
			'attributes'=>[
				'id'=>'is_admin',
				'class'=>'form-control'
			]
		]);
	}
}