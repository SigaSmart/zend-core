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

	public function createAction(){

	}
	public function editarAction(){

	}
	public function storeAction(){

	}
	public function deleteAction(){

	}
	public function stateAction(){

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
