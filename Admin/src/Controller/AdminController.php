<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Controller;

use Admin\Form\ModuleForm;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractController
{

	/**
	 * AdminController constructor.
	 *
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->getHelper();
	}

	public function moduleAction()
	{
		$view = new ViewModel();
		/**
		 * @var $ModuleForm ModuleForm
		 */
		$ModuleForm = $this->container->get(ModuleForm::class);
		if($this->params()->fromPost()):
			$Md = $this->params()->fromPost();
			$Md['status']=1;
			$ModuleForm->setData($Md);
			if($ModuleForm->isValid()):
				$Msg = copiar_diretorio("../data/Demo","../module/{$Md['module']}",$Md['classe']);
				$this->helper->addMessage($Msg,'success');
				return $this->redirect()->refresh();
				else:
				d($ModuleForm->getMessages());
			endif;
		endif;
		$view->setVariable('form',$ModuleForm);
		return $view;
	}
}