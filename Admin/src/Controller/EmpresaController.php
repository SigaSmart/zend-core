<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Controller;

use Admin\Api\Model\Empresa;
use Admin\Form\EmpresaForm;
use Admin\Model\EmpresaModel;
use Admin\Table\EmpresaTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class EmpresaController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->model = EmpresaModel::class;
		$this->table = EmpresaTable::class;
		$this->apiModel = Empresa::class;
		$this->form = EmpresaForm::class;
		$this->route = "admin/default";
		$this->controller = "empresa";
		$this->templateEdit = "admin/empresa/%s/editar-form";
		$this->getHelper();
	}

}