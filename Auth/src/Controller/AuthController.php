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

     $view = new ViewModel([
     	'form'=>$this->getForm()
	 ]);

     return $view;

	}

	public function registerAction(){
		 $this->getForm()->getModel();
		if($this->params()->fromPost()):
			$this->form->setData($this->params()->fromPost());
			$this->model->
            $this->form->setInputFilter($this->model->getInputFilter());
			if ($this->form->isValid()):
				var_dump($this->params()->fromPost());
				die;
			endif;
			var_dump($this->form->getMessages());
		endif;
		$view = new ViewModel([
			'form'=>$this->form
		]);
		return $view;
	}

	public function loginAction(){

		$auth = $this->container->get(Authentication::class);
		$result = $auth->login($this->params()->fromPost('email'),$this->params()->fromPost('password'));
		echo $auth->getResult();

	}


	public function recuprersenhaAction(){
		$view = new ViewModel([
			'form'=>$this->getForm()
		]);

		return $view;

	}
}