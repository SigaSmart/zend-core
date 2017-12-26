<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Home\Controller;


use Admin\Table\ProdutoTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->route = "home/default";
		$this->controller = "home";
		$this->table = ProdutoTable::class;
		//$this->templateEdit = "home/home/%s/editar-form";
		$this->getHelper();
	}

	public function produtosAction(){
           $this->getTable();

            $Data = $this->table->select();
            $view = new ViewModel([
            	'data'=>$Data
			]);

            return $view;
	}

}