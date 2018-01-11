<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 19/12/2017
 * Time: 14:53
 */

namespace Core\Service;


use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;

class Messages extends FlashMessenger
{

	public function addRedirect($url, $hops = 1)
	{
		return parent::addMessage($url, "redirect", $hops);
	}
	public function addTime($Time, $hops = 1)
	{
		return parent::addMessage($Time, "time", $hops);
	}

}