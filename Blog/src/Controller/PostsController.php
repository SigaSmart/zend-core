<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Blog\Controller;


use Blog\Api\Model\Posts;
use Blog\Form\PostsForm;
use Blog\Model\PostsModel;
use Blog\Table\PostsTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;

class PostsController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->table = PostsTable::class;
		$this->model = PostsModel::class;
		$this->apiModel = Posts::class;
		$this->form = PostsForm::class;
		$this->route = "blog/default";
		$this->controller = "posts";
		$this->templateEdit = "blog/posts/%s/editar-form";
		//$this->tenancy = false;
		$this->getHelper();
	}

}