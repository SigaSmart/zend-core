<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Controller;


use Admin\Api\Model\User;
use Admin\Form\UserForm;
use Admin\Model\UserModel;
use Admin\Table\UserTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class UserController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = UserTable::class;
		$this->model = UserModel::class;
		$this->apiModel = User::class;
		$this->form = UserForm::class;
		$this->route = "admin/default";
		$this->controller = "user";
		$this->templateEdit = "admin/user/%s/editar-form";
		$this->getHelper();
	}

}