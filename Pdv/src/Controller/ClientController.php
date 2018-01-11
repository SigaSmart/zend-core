<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Pdv\Controller;


use Pdv\Api\Model\Client;
use Pdv\Form\ClientForm;
use Pdv\Model\ClientModel;
use Pdv\Table\ClientTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Zend\Db\Sql\Predicate\In;

class ClientController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = ClientTable::class;
		$this->model = ClientModel::class;
		$this->apiModel = Client::class;
		$this->form = ClientForm::class;
		$this->route = "ponto-de-venda/default";
		$this->controller = "pdv";
		$this->templateEdit = "pdv/pdv/%s/editar-form";
		$this->getHelper();
	}
	public function clientAction(){
		$this->auth();
		$this->getTable()
			->getApiModel();
		$params = $this->getRequest()->getPost();
		$Source = $this->table->setTableModel($this->apiModel)
			->getSelect($params->toArray());
		if($this->tenancy):
			$Source->where(new In('empresa',$this->user->restrito));
		endif;
		$this->apiModel->setAdapter($this->getAdapter())
			->setSource($Source)
			->setUser($this->user)
			->setParamAdapter($params);

		//$view = $this->apiModel->render();
		//$view = $this->apiModel->render('custom',sprintf('admin/cidade/%s/listar', LAYOUT));
		//$view = $this->apiModel->render('dataTableAjaxInit');
		$view = $this->apiModel->render('dataTableJson');
		//$view = $this->apiModel->render('newDataTableJson');
		$view->setVariable('route',$this->route);
		$view->setVariable('controller',$this->controller);
		return $view;
	}

}