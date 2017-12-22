<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 00:23
 */

namespace Admin\Controller;


use Admin\Api\Model\Cidade;
use Admin\Form\CidadeForm;
use Admin\Model\CidadeModel;
use Admin\Table\CidadeTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class CidadeController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = CidadeTable::class;
		$this->model = CidadeModel::class;
		$this->apiModel = Cidade::class;
		$this->form = CidadeForm::class;
		$this->route = "admin/default";
		$this->controller = "cidade";
		$this->getHelper();
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

	public function createAction()
	{
		$this->auth();
		if (!$this->model):
			$this->args['msg'] = sprintf("Nenhuma model valida foi passada <b>%s</b>!", $this->user['first_name']);
			return new JsonModel($this->args);
		endif;
		if (!$this->table):
			$this->args['msg'] = sprintf("Nenhuma table valida foi passada <b>%s</b>!", $this->user['first_name']);
			return new JsonModel($this->args);
		endif;
		$this->getModel()->getTable();
		$this->model->offsetSet('empresa', $this->user->empresa);
		$this->args = array_merge($this->args, $this->table->insert($this->model));
		if ($this->args['result']):
			$this->args['redirect'] = $this->url()->fromRoute($this->route,[
				'controller' => $this->controller,
				'action'=>'editar',
				'id'=>$this->args['result']
			]);
		endif;
		return new JsonModel($this->args);
	}

	public function editarformAction()
	{
		$view = new ViewModel([
			'route'=>$this->route,
			'controller'=>$this->controller
		]);
		if (!$this->model):
			$this->args['msg'] = sprintf("Nenhuma model valida foi passada <b>%s</b>!", $this->user['first_name']);
		elseif (!$this->table):
			$this->args['msg'] = sprintf("Nenhuma table valida foi passada <b>%s</b>!", $this->user['first_name']);
		elseif (!$this->form):
			$this->args['msg'] = sprintf("Nenhum form valido foi passada <b>%s</b>!", $this->user['first_name']);
		else:
			$id = $this->params()->fromRoute("id",0);
			$this->setData()->getTable()->getModel();
			if ((int)$id):
				$this->model->exchangeArray($this->table->find($id));
				$this->getForm();
			else:
				$this->getForm();
				$this->store();
			endif;
		endif;
		$view->setTerminal(true);
		$view->setTemplate(sprintf("admin/cidade/%s/editar-form", LAYOUT));
		$view->setVariable('form', $this->form);
		return $view;
	}

	public function store()
	{
		if($this->getRequest()->isPost()):
			$uploadedFiles = $this->params()->fromFiles();
			if ($uploadedFiles):
				// handle single input with single file upload
				//$Upload = new UploadAbstract($uploadedFiles['attachment']);
				//$this->model->offsetSet($this->cover, $Upload->moveUploadedFile());
			endif;
			//setamos o adapter no model
			$this->form->setInputFilter($this->model->getInputFilter());
			if ($this->form->isValid()):
				//validamos a model
				$this->args = array_merge($this->args, $this->table->save($this->model));
				$this->helper->addMessage($this->args['msg'],$this->args['type']);
			endif;
			return new JsonModel($this->args);
		endif;
	}

	public function deleteAction()
	{
		$this->getTable();
		$Resul = $this->table->delete($this->params()->fromPost('id'));
		return new JsonModel($Resul);
	}

	public function stateAction()
	{
		$this->getTable();
		$Resul = $this->table->state(['status'=>$this->params()->fromRoute('id')], $this->params()->fromPost('id'));
		return new JsonModel($Resul);
	}

}