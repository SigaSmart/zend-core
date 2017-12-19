<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 18/12/2017
 * Time: 07:57
 */

namespace Auth\Model;


use Core\Model\AbstractModel;
use Zend\InputFilter\InputFilter;

class LoginModel extends AbstractModel
{
	public function getInputFilter()
	{
		if (!$this->inputFilter):
			$this->inputFilter = new InputFilter();
			$this->inputFilter->add([
				'name'=>'first_name',
				'required'=>true,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Nome'),
					$this->NotEmpty('Nome'),
				]
			]);

			$this->inputFilter->add([
				'name'=>'last_name',
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Sobre Nome'),
					$this->NotEmpty('Sobre Nome'),
				]
			]);

			$this->inputFilter->add([
				'name'=>'email',
				'required'=>true,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->NoRecordExists(),
					$this->StringLength('E-Mail'),
					$this->NotEmpty('E-Mail'),
				]
			]);

			$this->inputFilter->add([
				'name'=>'role',
				'required'=>false,
				'filters'=>$this->filters(),
				'validators'=>[]
			]);

			$this->inputFilter->add([
				'name'=>'status',
				'required'=>false,
				'filters'=>$this->filters(),
				'validators'=>[]
			]);

			$this->inputFilter->add([
				'name'=>'password',
				'required'=>true,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Senha'),
					$this->NotEmpty('Senha'),
				]
			]);

		endif;
		return parent::getInputFilter(); // TODO: Change the autogenerated stub
	}

	public function getInputFilterProfile()
	{
		if (!$this->inputFilter):
			$this->inputFilter = new InputFilter();
			$this->inputFilter->add([
				'name'=>'first_name',
				'required'=>true,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Nome'),
					$this->NotEmpty('Nome'),
				]
			]);

			$this->inputFilter->add([
				'name'=>'last_name',
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Sobre Nome'),
					$this->NotEmpty('Sobre Nome'),
				]
			]);

			$this->inputFilter->add([
				'name'=>'email',
				'required'=>true,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->NoRecordExists(),
					$this->StringLength('E-Mail'),
					$this->NotEmpty('E-Mail'),
				]
			]);

			$this->inputFilter->add([
				'name'=>'password',
				'required'=>true,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Senha'),
					$this->NotEmpty('Senha'),
				]
			]);

		endif;
		return parent::getInputFilter(); // TODO: Change the autogenerated stub
	}

	public function getInputFilterLogin()
	{
		if (!$this->inputFilter):
			$this->inputFilter = new InputFilter();

			$this->inputFilter->add([
				'name'=>'email',
				'required'=>true,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->RecordExists(),
					$this->StringLength('E-Mail'),
					$this->NotEmpty('E-Mail'),
				]
			]);

			$this->inputFilter->add([
				'name'=>'password',
				'required'=>true,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Senha'),
					$this->NotEmpty('Senha'),
				]
			]);

		endif;
		return parent::getInputFilter(); // TODO: Change the autogenerated stub
	}

	public function getInputFilterRecuperarSenha()
	{
		if (!$this->inputFilter):
			$this->inputFilter = new InputFilter();
			$this->inputFilter->add([
				'name'=>'email',
				'required'=>true,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->RecordExists(),
					$this->StringLength('E-Mail'),
					$this->NotEmpty('E-Mail'),
				]
			]);
		endif;
		return parent::getInputFilter(); // TODO: Change the autogenerated stub
	}


}