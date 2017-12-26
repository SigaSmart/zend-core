<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Controller;


use Admin\Api\Model\Menu;
use Admin\Form\MenuForm;
use Admin\Model\MenuModel;
use Admin\Table\MenuTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class MenuController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = MenuTable::class;
		$this->model = MenuModel::class;
		$this->apiModel = Menu::class;
		$this->form = MenuForm::class;
		$this->route = "admin/default";
		$this->controller = "menu";
		$this->templateEdit = "admin/menu/%s/editar-form";
		$this->getHelper();
	}

}