<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 02/01/2018
 * Time: 13:35
 */

namespace Webblog;


class Module
{

	const VERSION = '3.0.3-dev';

	public function getConfig()
	{
		return include __DIR__ . '/../config/module.config.php';
	}
}