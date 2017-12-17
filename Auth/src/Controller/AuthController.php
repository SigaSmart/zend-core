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
	}

	public function indexAction()
	{

     $view = new ViewModel([
     	'form'=>$this->getForm()
	 ]);

     return $view;

	}

	public function registerAction(){
// Build a query to insert a row for which authentication may succeed
	$sqlInsert = "INSERT INTO users (
		empresa, 
		first_name,
		last_name,
		email,
		password,
		status,
		role
		) VALUES ('1', 'Claudio', 'Campos','callcocam@gmail.com','123',1,'admin')";
		// Insert the data
		$this->adapter->query($sqlInsert, $this->adapter::QUERY_MODE_EXECUTE);

	}

	public function loginAction(){

		$auth = $this->container->get(Authentication::class);
		$result = $auth->login($this->params()->fromPost('email'),$this->params()->fromPost('password'));
		echo $auth->getResult();

	}


	public function recuprersenhaAction(){


	}
}