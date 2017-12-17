<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/12/2017
 * Time: 21:13
 */

namespace Core\Form;

use Zend\Form\Form;

class AbstractForm extends Form
{
	protected $container;
	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);

		if(isset($options['container'])):
			$this->container = $options['container'];
		endif;

	}

}