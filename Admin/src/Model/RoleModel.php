<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Model;


use Core\Model\AbstractModel;
use Zend\InputFilter\InputFilter;

class RoleModel extends AbstractModel
{
	public function getInputFilter()
	{
		if (!$this->inputFilter):
			$this->inputFilter = new InputFilter();
			########################### parent ####################
			$this->inputFilter->add([
				'name'=>'parent',
				'required'=>false,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Menu Principal'),

				]
			]);
			########################### is_admin ####################
			$this->inputFilter->add([
				'name'=>'is_admin',
				'required'=>false,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Todos os privilégios'),

				]
			]);
		endif;
		return parent::getInputFilter(); // TODO: Change the autogenerated stub
	}
}