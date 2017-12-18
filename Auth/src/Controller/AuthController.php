<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/12/2017
 * Time: 14:34
 */

namespace Auth\Controller;


use Auth\Adapter\Authentication;
use Auth\Form\LoginForm;
use Auth\Model\LoginModel;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->adapter = $this->container->get(AdapterInterface::class);
		$this->form = LoginForm::class;
		$this->model = LoginModel::class;
	}
	public function indexAction()
	{
	}
	public function loginformAction(){
		$this->setData()
			->getModel()
			->getForm();
		if($this->data):
			$this->form->setInputFilter($this->model->getInputFilter());
			if ($this->form->isValid()):
				$auth = $this->container->get(Authentication::class);
				$result = $auth->login($this->params()->fromPost('email'),$this->params()->fromPost('password'));
				echo $auth->getResult();
			endif;
		endif;
		$view = new ViewModel([
			'form'=>$this->form
		]);
		$view->setTerminal(true);
		return $view;
	}

	public function registerAction(){
	}

	public function registerformAction(){
		$this->setData()
			->getModel()
			->getForm();
		if($this->data):
			$this->form->setInputFilter($this->model->getInputFilter());
			if ($this->form->isValid()):

			endif;
		endif;
		$view = new ViewModel([
			'form'=>$this->form
		]);
		$view->setTerminal(true);
		return $view;
	}

	public function recuperarsenhaAction(){
	}

	public function recuperarsenhaformAction(){
		$this->setData()
			->getModel()
			->getForm();
		if($this->params()->fromPost()):
			$this->form->setInputFilter($this->model->getInputFilter());
			if ($this->form->isValid()):

			endif;
		endif;
		$view = new ViewModel([
			'form'=>$this->form
		]);
		$view->setTerminal(true);
		return $view;

	}
}