<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Controller;


use Admin\Api\Model\Produto;
use Admin\Form\ProdutoForm;
use Admin\Model\ProdutoModel;
use Admin\Table\ProdutoTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class ProdutoController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = ProdutoTable::class;
		$this->model = ProdutoModel::class;
		$this->apiModel = Produto::class;
		$this->form = ProdutoForm::class;
		$this->route = "admin/default";
		$this->controller = "produto";
		$this->templateEdit = "admin/produto/%s/editar-form";
		$this->getHelper();
	}

}