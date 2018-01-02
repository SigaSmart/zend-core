<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Controller;


use Admin\Api\Model\Privilege;
use Admin\Form\PrivilegeForm;
use Admin\Model\PrivilegeModel;
use Admin\Table\PrivilegeTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class PrivilegeController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = PrivilegeTable::class;
		$this->model = PrivilegeModel::class;
		$this->apiModel = Privilege::class;
		$this->form = PrivilegeForm::class;
		$this->route = "admin/default";
		$this->controller = "privilege";
		$this->templateEdit = "admin/privilege/%s/editar-form";
		$this->tenancy = false;
		$this->getHelper();
	}

}