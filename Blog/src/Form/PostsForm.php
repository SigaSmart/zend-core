<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Blog\Form;


use Core\Form\AbstractForm;
use Zend\Form\Element\File;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;

class PostsForm extends AbstractForm
{

	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);
		$this->setAttribute('class','form-horizontal');
		$this->user();
		//Add os campos abaixo voce pode usar o comando
		// zf-input-text ou zf-input-select ou zf-input-checkbox ou zf-input-radio
		################# name #################
		$this->add([
			'type'=>Text::class,
			'name'=>'name',
			'options'=>[
				'label'=>'Nome Do Post'
			],
			'attributes'=>[
				'id'=>'name',
				'class'=>'form-control',
				'placeholder'=>'Nome Do Post',
				'required'=>true
			]
		]);

		################# author #################
		$this->add([
			'type'=>Hidden::class,
			'name'=>'author',
			'attributes'=>[
				'id'=>'author',
				'value'=>$this->users->id
			]
		]);

		$Select = $this->dbValueOptions(\Blog\Table\CategorieTable::class, ['status'=>1]);
		$Select->where(new \Zend\Db\Sql\Predicate\In('empresa', $this->users->restrito));
		################# categorie #################
		$this->add([
			'type'=> \Zend\Form\Element\Select::class,
			'name'=>'categorie',
			'options'=>[
				'disable_inarray_validator'=>true,
				'label'=>'Categoria',
				'empty_option'=>'--Selecione--',
				'value_options'=>$this->getValueDb($Select)
			],
			'attributes'=>[
				'id'=>'categorie',
				'class'=>'form-control'
			]
		]);

		################# preview #################
		$this->add([
			'type'=>Text::class,
			'name'=>'preview',
			'options'=>[
				'label'=>'Descrição curta'
			],
			'attributes'=>[
				'id'=>'preview',
				'class'=>'form-control',
				'placeholder'=>'Descrição curta',
				'required'=>true,
			]
		]);

		################# description #################
		$this->add([
			'type'=>Textarea::class,
			'name'=>'description',
			'options'=>[
				'label'=>'Conteudo'
			],
			'attributes'=>[
				'id'=>'content',
				'class'=>'form-control tiny_mce',
				'placeholder'=>'Conteudo',
				'required'=>true,
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