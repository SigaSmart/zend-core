<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Controller;


use Admin\Api\Model\Cidade;
use Admin\Form\CidadeForm;
use Admin\Model\CidadeModel;
use Admin\Table\CidadeTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class CidadeController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = CidadeTable::class;
		$this->model = CidadeModel::class;
		$this->apiModel = Cidade::class;
		$this->form = CidadeForm::class;
		$this->route = "admin/default";
		$this->controller = "cidade";
		$this->templateEdit = "admin/cidade/%s/editar-form";
		$this->tenancy = false;
		$this->getHelper();
	}

}