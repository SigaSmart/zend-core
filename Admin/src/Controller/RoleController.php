<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Controller;


use Admin\Api\Model\Role;
use Admin\Form\RoleForm;
use Admin\Model\RoleModel;
use Admin\Table\RoleTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class RoleController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = RoleTable::class;
		$this->model = RoleModel::class;
		$this->apiModel = Role::class;
		$this->form = RoleForm::class;
		$this->route = "admin/default";
		$this->controller = "role";
		$this->templateEdit = "admin/role/%s/editar-form";
		$this->getHelper();
	}

}