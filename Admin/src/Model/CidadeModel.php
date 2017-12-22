<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Model;


use Core\Model\AbstractModel;
use Zend\InputFilter\InputFilter;

class CidadeModel extends AbstractModel
{

	public function getInputFilter()
	{
		if (!$this->inputFilter):
			$this->inputFilter = new InputFilter();
		endif;
		return parent::getInputFilter();
	}

}