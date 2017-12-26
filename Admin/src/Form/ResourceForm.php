<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Form;


use Core\Form\AbstractForm;
use Zend\Form\Element\Text;

class ResourceForm extends AbstractForm
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

		    ################# alias #################
				$this->add([
					'type'=>Text::class,
					'name'=>'alias',
					'options'=>[
						'label'=>'Nome real'
					],
					'attributes'=>[
						'id'=>'alias',
						'class'=>'form-control',
						'placeholder'=>'Nome real Nome:Meu Admin -> MeuAdmin ou Admin',
						'required'=>true,
					]
				]);

				################# route  #################
				$this->add([
					'type'=>Text::class,
					'name'=>'route',
					'options'=>[
						'label'=>'Rota'
					],
					'attributes'=>[
						'id'=>'route',
						'class'=>'form-control',
						'placeholder'=>'route',
						'required'=>true,
					]
				]);
	}
}