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
use Auth\Table\LoginTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Zend\Crypt\Key\Derivation\Pbkdf2;
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
		$this->table = LoginTable::class;
		$this->getHelper();
	}
	public function loginAction()
	{
		$this->quest();
		$view = new ViewModel();
		$view->setTemplate(sprintf("auth/%s/login", LAYOUT));
		return $view;
	}
	public function loginformAction(){

		$this->quest();
		$this->setData()
			->getModel()
			->getForm();
		if($this->data):
			$this->form->setInputFilter($this->model->getInputFilterLogin());
			if ($this->form->isValid()):
				$auth = $this->container->get(Authentication::class);
			    $password = $this->encryptPassword($this->params()->fromPost('email'),$this->params()->fromPost('password'));
				$Result = $auth->login($this->params()->fromPost('email'),$password);
				$this->helper->addMessage($auth->getResult(),$auth->getType());
				if($Result->isValid()):
					$this->helper->addRedirect("admin");
				endif;
			endif;
		endif;
		$view = new ViewModel([
			'form'=>$this->form
		]);
		$view->setTerminal(true);
		$view->setTemplate(sprintf("auth/%s/login-form", LAYOUT));
		return $view;
	}

	public function registerAction(){
		$this->quest();
		$view = new ViewModel();
		$view->setTemplate(sprintf("auth/%s/register", LAYOUT));
		return $view;
	}

	public function registerformAction(){
		$this->quest();
		$this->setData()
			->getModel()
			->getForm()
			->getTable();
		if($this->data):
			$this->form->setInputFilter($this->model->getInputFilter());
			if ($this->form->isValid()):
				 $this->model->offsetSet("password" ,md5($this->encryptPassword($this->model->offsetGet('email'),$this->model->offsetGet('password'))));
				 $this->args = array_merge($this->args, $this->table->insert($this->model));
				 $this->helper->addMessage($this->args['msg'],$this->args['type']);
				 if($this->args['result']):
				   $this->helper->addRedirect("auth");
				 endif;
			endif;
		endif;
		$view = new ViewModel([
			'form'=>$this->form
		]);
		$view->setTerminal(true);
		$view->setTemplate(sprintf("auth/%s/register-form", LAYOUT));
		return $view;
	}

	public function recuperarsenhaAction(){
		$this->quest();
		$view = new ViewModel();
		$view->setTemplate(sprintf("auth/%s/recuperar-senha", LAYOUT));
		return $view;
	}

	public function recuperarsenhaformAction(){
		$this->quest();
		$this->setData()
			->getModel()
			->getForm();
		if($this->params()->fromPost()):
			$this->form->setInputFilter($this->model->getInputFilterRecuperarSenha());
			if ($this->form->isValid()):

			endif;
		endif;
		$view = new ViewModel([
			'form'=>$this->form
		]);
		$view->setTerminal(true);
		$view->setTemplate(sprintf("auth/%s/recuperar-senha-form", LAYOUT));
		return $view;

	}


	public function sairAction(){
		$this->auth();
		$auth = $this->container->get(Authentication::class);
		$auth->clearIdentity();
		return $this->redirect()->toRoute("auth");
	}


	public function encryptPassword($email, $password)
	{
		return base64_encode(Pbkdf2::calc('sha256', $password, $email, 10000, strlen($password*2)));
	}
}