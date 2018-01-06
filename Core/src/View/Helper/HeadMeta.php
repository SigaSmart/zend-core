<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/01/2018
 * Time: 11:13
 */

namespace Core\View\Helper;


class HeadMeta extends \Zend\View\Helper\HeadMeta
{
	protected $title;

	/**
	 * @return mixed
	 */
	public function pageTitle($title=null){
		if($title):
			$this->title = $title;
			else:
		     return $this->title;
		endif;
		return $this;
	}

}