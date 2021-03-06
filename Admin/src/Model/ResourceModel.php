<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Model;


use Core\Model\AbstractModel;
use Zend\InputFilter\InputFilter;

class ResourceModel extends AbstractModel
{
	public function getInputFilter()
	{
		if (!$this->inputFilter):
			$this->inputFilter = new InputFilter();
			########################### alias ####################
			$this->inputFilter->add([
				'name'=>'alias',
				'required'=>false,
				'filters'=>$this->filters(),
				'validators'=>[
					$this->StringLength('Alias'),
				]
			]);
		endif;
		return parent::getInputFilter(); // TODO: Change the autogenerated stub
	}
}