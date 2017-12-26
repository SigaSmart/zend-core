<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Form;


use Core\Form\AbstractForm;
use Zend\Form\Element\Text;

class CidadeForm extends AbstractForm
{

	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);
        $this->setAttribute('class','form-horizontal');
		$this->add([
			'type'=>Text::class,
			'name'=>'title',
			'options'=>[
				'label'=>'Nome Da Cidade'
			],
			'attributes'=>[
				'id'=>'title',
				'class'=>'form-control'
			]
		]);

	}
}