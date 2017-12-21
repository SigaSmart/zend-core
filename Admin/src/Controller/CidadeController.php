<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 00:23
 */

namespace Admin\Controller;


use Admin\Api\Model\Cidade;
use Admin\Model\CidadeModel;
use Admin\Table\CidadeTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\JsonModel;

class CidadeController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = CidadeTable::class;
		$this->model = CidadeModel::class;
		$this->apiModel = Cidade::class;
	}

	public function listarAction(){

		$this->getTable()
			->getApiModel();
		$this->apiModel->setAdapter($this->getAdapter())
			->setSource($this->table->setTableModel($this->apiModel)
				->getSelect($this->params()->fromPost()))
			->setParamAdapter($this->getRequest()->getPost());

		$view = $this->apiModel->render();
		//$view = $this->apiModel->render('custom',sprintf('admin/cidade/%s/listar', LAYOUT));
		//$view = $this->apiModel->render('dataTableAjaxInit');
		//$view = $this->apiModel->render('dataTableJson');
		//$view = $this->apiModel->render('newDataTableJson');
		$view->setVariable('route',"admin");
		$view->setVariable('controller',"cidade");
		return $view;
	}

	public function stateAction()
	{
		$this->getTable();
		$Resul = $this->table->state(['status'=>$this->params()->fromRoute('id')], $this->params()->fromPost('id'));
		return new JsonModel($Resul);
	}

}