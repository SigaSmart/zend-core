<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/01/2018
 * Time: 15:34
 */

namespace Webblog\Form;


use Core\Form\AbstractForm;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Email;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class ContactForm extends AbstractForm
{
	public function __construct($name = null, array $options = [])
	{
		parent::__construct('AjaxUploadForm', $options);

		// Set POST method for this form.
		$this->setAttribute('method', 'post');

		// Set binary content encoding.
		$this->setAttribute('enctype', 'multipart/form-data');

		$this->addElements();
	}

	// This method adds elements to form.
	protected function addElements()
	{
		################# name #################
		$this->add([
			'type'=>Text::class,
			'name'=>'name',
			'options'=>[
				//'label'=>'Nome Completo'
			],
			'attributes'=>[
				'id'=>'name',
				//'class'=>'form-control',
				'placeholder'=>'Nome Completo',
				'title'=>'Nome Completo',
				'required'=>true
			]
		]);

		################# email #################
		$this->add([
			'type'=>Text::class,
			'name'=>'email',
			'options'=>[
				//'label'=>'Seu Email'
			],
			'attributes'=>[
				'id'=>'email',
				//'class'=>'form-control',
				'placeholder'=>'Seu Email',
				'title'=>'Seu Email',
				'required'=>true
			]
		]);

		################# phone #################
		$this->add([
			'type'=>Text::class,
			'name'=>'phone',
			'options'=>[
				//'label'=>'Telefone'
			],
			'attributes'=>[
				'id'=>'phone',
				//'class'=>'form-control',
				'placeholder'=>'Telefone',
				'title'=>'Telefone',
			]
		]);

		################# message #################
		$this->add([
			'type'=>Textarea::class,
			'name'=>'message',
			'options'=>[
				//'label'=>'Menssagem'
			],
			'attributes'=>[
				'id'=>'message',
				//'class'=>'form-control',
				'placeholder'=>'Menssagem',
				'title'=>'Menssagem',
				'required'=>true,
			]
		]);

	}

	// This method creates input filter (used for form filtering/validation).
	public function addInputFilter()
	{

		$inputFilter = new InputFilter();
		########################### name ####################
		$inputFilter->add([
			'name'=>'name',
			'required'=>true,
			'filters'=>[

				[
					'name'=>StringTrim::class,
				],
				[
					'name'=>StripTags::class
				]

			],
			'validators'=>[
				[
					'name' => StringLength::class,
					'options' => [
						'max' => 100,
						'min' => 5,
						'messages' => [
							StringLength::TOO_SHORT => "Campo [ Nome Completo ] Muito Curto",
							StringLength::TOO_LONG => "Campo [ Nome Completo ] Muito Longo",
						],
					],
				],
				[
					'name' => NotEmpty::class,
					'options' => [
						'messages' => [NotEmpty::IS_EMPTY => "Campo [ Nome Completo ] Obrigatorio"],
					]
				]
			]
		]);
		########################### email ####################
		$inputFilter->add([
			'name'=>'email',
			'required'=>true,
			'filters'=>[

				[
					'name'=>StringTrim::class,
				],
				[
					'name'=>StripTags::class
				]

			],
			'validators'=>[
				[
					'name' => StringLength::class,
					'options' => [
						'max' => 100,
						'min' => 10,
						'messages' => [
							StringLength::TOO_SHORT => "Campo [ E-Mail ] Muito Curto",
							StringLength::TOO_LONG => "Campo [  E-Mail  ] Muito Longo",
						],
					],
				],
				[
					'name' => EmailAddress::class,
					'options' => [
						'messages' => [
							EmailAddress::INVALID => " E-Mail Inválido",
							EmailAddress::INVALID_FORMAT => "O Formato E-Mail é inválido",
							EmailAddress::INVALID_HOSTNAME => "O Host do E-Mail é inválido",
						],
					],
				],
				[
					'name' => NotEmpty::class,
					'options' => [
						'messages' => [NotEmpty::IS_EMPTY => "Campo [  E-Mail ] Obrigatorio"],
					]
				]
			]
		]);

		########################### message ####################
		$inputFilter->add([
			'name'=>'message',
			'required'=>true,
			'filters'=>[

				[
					'name'=>StringTrim::class,
				],
				[
					'name'=>StripTags::class
				]

			],
			'validators'=>[
				[
					'name' => StringLength::class,
					'options' => [
						'max' => 1000,
						'min' => 5,
						'messages' => [
							StringLength::TOO_SHORT => "Campo [ Menssagem ] Muito Curto",
							StringLength::TOO_LONG => "Campo [ Menssagem ] Muito Longo",
						],
					],
				],
				[
					'name' => NotEmpty::class,
					'options' => [
						'messages' => [NotEmpty::IS_EMPTY => "Campo [ Menssagem ] Obrigatorio"],
					]
				]
			]
		]);
		return $inputFilter;
	}
}