<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 18/12/2017
 * Time: 18:28
 */

namespace Core\Table;


class Utils
{

	const SUCCESS = 'success';
	const DANGER = 'danger';
	const INFO = 'info';

	public function clear($Data){
		if(is_array($Data)):
			return array_filter($Data);
		endif;
		return $Data;
	}


}