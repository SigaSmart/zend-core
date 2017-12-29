<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Model;


use Core\Model\AbstractModel;
use Zend\InputFilter\InputFilter;

class PrivilegeModel extends AbstractModel
{
	public function getInputFilter()
	{
		if (!$this->inputFilter):
			$this->inputFilter = new InputFilter();
			########################### controller ####################
			$this->inputFilter->add([
				'name'=>'controller',
				'required'=>true,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Controller'),
					$this->NotEmpty('Controller')

				]
			]);
			########################### parent ####################
			$this->inputFilter->add([
				'name'=>'parent',
				'required'=>false,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Herdar'),

				]
			]);
		endif;
		return parent::getInputFilter(); // TODO: Change the autogenerated stub
	}
}