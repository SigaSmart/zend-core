<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 00:23
 */

namespace Admin\Controller;


use Admin\Api\Model\Cidade;
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
	}

	public function testAction(){

		$this->getTable();
		$table = new Cidade();
		$table->setAdapter($this->getAdapter())
			->setSource($this->table->getSelect())
			->setParamAdapter($this->getRequest()->getPost());
		return $this->htmlResponse($table->render());
	}

	public function htmlResponse($html)
	{
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$response->setContent($html);
		return $response;
	}
}