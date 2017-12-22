<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core\Controller;

use Core\Form\AbstractForm;
use Core\Model\AbstractModel;
use Core\Service\Messages;
use Core\Table\AbstractTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

abstract class AbstractController extends AbstractActionController
{
	/**
	 * @var $adapter AdapterInterface
	 */
	protected $adapter;
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @var $form AbstractForm
	 */
	protected $form;
	/**
	 * @var $model AbstractModel
	 */
	protected $model;

	/**
	 * @var $apiModel \Core\AbstractTable
	 */
	protected $apiModel;

	/**
	 * @var $table AbstractTable
	 */
	protected $table;

	protected $data=[];


	protected $helper;

	protected $route = "admin";

	protected $controller = "admin";

	protected $action = "index";

	protected $templateEdit = "admin/%s/editar-form";

	protected $args = [
		'icon' => 'fa fa-warning',
		'title' => 'OPPSS!',
		'msg' => 'Não conseguimos atender a sua solicitação!',
		'type' => 'danger',
	];


	protected $user;

	abstract public  function __construct(ContainerInterface $container);

	/**
	 * @return ViewModel
	 */
	public function indexAction()
	{
		$this->auth();
		return new ViewModel();
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
		$view->setVariable('controller',$this->controller);
		return $view;
	}

	public function createAction(){
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
	public function editarAction(){
		$view = new ViewModel([
			'route'=>$this->route,
			'controller'=>$this->controller
		]);
		return $view;
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
		$view->setTemplate(sprintf($this->templateEdit, LAYOUT));
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

	/**
	 * @return $this
	 */
	public function getForm()
	{
		$this->form = $this->container->get($this->form);
		$this->form->setData($this->model->getArrayCopy());
		return $this;
	}

	/**
	 * @return $this
	 */
	public function getModel()
	{
		$this->model = $this->container->get($this->model);
		$this->model->exchangeArray($this->data);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function getTable()
	{
		$this->table = $this->container->get($this->table);
		return $this;
	}

	/**
	 * @return \Core\AbstractTable
	 */
	public function getApiModel()
	{
		$this->apiModel = $this->container->get($this->apiModel);
		return $this;
	}

	public function setData()
	{
		$this->data = $this->params()->fromPost();
		unset($this->data['submit']);
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getHelper()
	{
		$this->helper = new Messages();
		return $this;
	}

	/**
	 * @return AdapterInterface
	 */
	public function getAdapter()
	{
		$this->adapter = $this->container->get(AdapterInterface::class);
		return $this->adapter;
	}


	/**
	 * @return \Zend\Http\Response
	 */
	protected function auth(){
		if(!$this->identity()):
			return $this->redirect()->toRoute("auth");
		endif;
		$this->user = $this->identity();
	}
	protected function quest(){
		if($this->identity()):
			return $this->redirect()->toRoute("admin");
		endif;
	}




}
