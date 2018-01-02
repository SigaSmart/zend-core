<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Blog\Form;


use Core\Form\AbstractForm;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;

class CategorieForm extends AbstractForm
{

	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);
		$this->setAttribute('class','form-horizontal');
		//Add os campos abaixo voce pode usar o comando
		// zf-input-text ou zf-input-select ou zf-input-checkbox ou zf-input-radio
        $this->user();
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
				'value'=>"",
			]
		]);

		$Select = $this->dbValueOptions(\Blog\Table\CategorieTable::class, ['status'=>1]);
		$Select->where(new \Zend\Db\Sql\Predicate\IsNull('parent'));
		$Select->where(new \Zend\Db\Sql\Predicate\In('empresa',$this->users->restrito));
		################# parent #################
		$this->add([
			'type'=> \Zend\Form\Element\Select::class,
			'name'=>'parent',
			'options'=>[
				'disable_inarray_validator'=>true,
				'label'=>'Sessão',
				'empty_option'=>'--Selecione--',
				'value_options'=>$this->getValueDb($Select)
			],
			'attributes'=>[
				'id'=>'parent',
				'class'=>'form-control'
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