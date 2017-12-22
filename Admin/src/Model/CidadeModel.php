<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 00:29
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