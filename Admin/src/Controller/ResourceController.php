<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Controller;


use Admin\Api\Model\Resource;
use Admin\Form\ResourceForm;
use Admin\Model\ResourceModel;
use Admin\Table\ResourceTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class ResourceController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = ResourceTable::class;
		$this->model = ResourceModel::class;
		$this->apiModel = Resource::class;
		$this->form = ResourceForm::class;
		$this->route = "admin/default";
		$this->controller = "resource";
		$this->templateEdit = "admin/resource/%s/editar-form";
		$this->getHelper();
	}

}