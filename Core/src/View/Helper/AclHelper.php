<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/12/2017
 * Time: 09:38
 */

namespace Core\View\Helper;


use Core\Acl;
use Zend\View\Helper\AbstractHelper;

class AclHelper extends AbstractHelper
{

	/**
	 * @var Acl
	 */
	private $acl;

	public function __construct(Acl $acl)
	{
		$this->acl = $acl;
	}

	public function getAcl(){
         return $this->acl;
	}
}