<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/12/2017
 * Time: 14:39
 */

namespace Auth\Controller\Factory;


use Auth\Controller\AuthController;
use Interop\Container\ContainerInterface;

class AuthControllerFactoy
{

	public function __invoke(ContainerInterface $container)
	{
		return new AuthController($container);
	}
}