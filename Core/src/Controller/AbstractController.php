<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core\Controller;

use Core\Form\AbstractForm;
use Core\Model\AbstractModel;
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
	 * @var $table AbstractTable
	 */
	protected $table;

	protected $data=[];


	protected $helper;



	abstract public  function __construct(ContainerInterface $container);

	public function indexAction()
	{

		//var_dump($this->adapter->query("SELECT * FROM users"));
		return new ViewModel();
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
		$this->helper = new FlashMessenger();
		return $this;
	}





}
