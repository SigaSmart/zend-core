<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Auth\Controller;


use Admin\Model\EmpresaModel;
use Admin\Table\EmpresaTable;
use Auth\Adapter\Authentication;
use Auth\Adapter\Company;
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
		$this->route = "auth/default";
		$this->controller = "auth";
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
					$Company = $this->container->get(Company::class);
					$Company->matriz($this->identity()->empresa);
					$this->identity()->restrito = $Company->getRestrito();
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
		$view = new ViewModel([
			'route'=>$this->route,
			'controller'=>$this->controller
		]);
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
					$EmpresaTable = $this->container->get(EmpresaTable::class);
				    $EmpresaModel = $this->container->get(EmpresaModel::class);
				    $EmpresaModel->offsetSet("tipo",1);
					$EmpresaModel->offsetSet("status",1);
					$Result = $EmpresaTable->save($EmpresaModel);
					if($Result['result']):
						$this->model->offsetSet("id",$this->args['result']);
						$this->model->offsetSet("empresa",$Result['result']);
						$this->table->save($this->model);
					endif;
					$this->helper->addRedirect("auth");
				endif;
			endif;
		endif;
		$view = new ViewModel([
			'route'=>$this->route,
			'controller'=>$this->controller,
			'form'=>$this->form
		]);
		$view->setTerminal(true);
		$view->setTemplate(sprintf("auth/%s/register-form", LAYOUT));
		return $view;
	}


	public function profileAction(){
		$this->auth();
		$view = new ViewModel();
		$view->setTemplate(sprintf("auth/%s/profile", LAYOUT));
		$view->setVariable('data',$this->user);
		return $view;
	}
	public function profileformAction(){
		$this->auth();
		$this->setData()
				->getModel()
					->getForm()
						->getTable();
		if($this->params()->fromPost()):
			$this->form->setInputFilter($this->model->getInputFilterProfile());
			if ($this->form->isValid()):
				if(empty($this->model->offsetGet('password'))):
					$this->model->offsetUnset('password');
					else:
					$this->model->offsetSet("password" ,md5($this->encryptPassword($this->model->offsetGet('email'),$this->model->offsetGet('password'))));
				endif;
			    $this->args = array_merge($this->args, $this->table->save($this->model));
				$this->helper->addMessage($this->args['msg'],$this->args['type']);
				else:
					$this->helper->addMessage("Formulario invalido",'error');
			endif;
		else:
			$this->form->setData($this->container->get(Authentication::class)->toArray());
		endif;
		$view = new ViewModel([
			'route'=>$this->route,
			'controller'=>$this->controller,
			'form'=>$this->form
		]);
		$view->setTerminal(true);
		$view->setTemplate(sprintf("auth/%s/profile-form", LAYOUT));
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