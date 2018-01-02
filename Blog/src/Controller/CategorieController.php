<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Blog\Controller;


use Blog\Api\Model\Categorie;
use Blog\Form\CategorieForm;
use Blog\Model\CategorieModel;
use Blog\Table\CategorieTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class CategorieController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = CategorieTable::class;
		$this->model = CategorieModel::class;
		$this->apiModel = Categorie::class;
		$this->form = CategorieForm::class;
		$this->route = "blog/default";
		$this->controller = "categorie";
		$this->templateEdit = "blog/categorie/%s/editar-form";
		$this->getHelper();
	}

}