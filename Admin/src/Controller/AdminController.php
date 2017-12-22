<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Controller;

use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class AdminController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}


}
