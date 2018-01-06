<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core\Controller;

use Admin\Form\GalleryForm;
use Admin\Form\MdDefaultForm;
use Admin\Form\UploadForm;
use Admin\Model\GalleryModel;
use Admin\Table\GalleryTable;
use Core\Acl;
use Core\Form\AbstractForm;
use Core\Model\AbstractModel;
use Core\Service\ImageManager;
use Core\Service\Messages;
use Core\Table\AbstractTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Predicate\In;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

abstract class AbstractController extends AbstractActionController
{
	/**
	 * @var $adapter AdapterInterface
	 */
	protected $adapter;
	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @var $form AbstractForm
	 */
	protected $form;
	/**
	 * @var $model AbstractModel
	 */
	protected $model;

	/**
	 * @var $apiModel \Core\AbstractTable
	 */
	protected $apiModel;

	/**
	 * @var $acl Acl
	 */
	protected $acl;
	/**
	 * @var $table AbstractTable
	 */
	protected $table;

	protected $data=[];

	protected $page = 1;

	protected $itemPage = 12;

	protected $tenancy = true;

	protected $helper;

	protected $route = "admin";

	protected $controller = "admin";

	protected $action = "index";

	protected $templateEdit = "admin/%s/editar-form";

	protected $args = [
		'icon' => 'fa fa-warning',
		'title' => 'OPPSS!',
		'msg' => 'Não conseguimos atender a sua solicitação!',
		'type' => 'danger',
	];


	protected $user;
	/**
	 * @var $imageManager ImageManager
	 */
	private $imageManager;
	protected $cover = "cover";

	abstract public  function __construct(ContainerInterface $container);

	/**
	 * @return ViewModel
	 */
	public function indexAction()
	{
		$this->auth();
		return new ViewModel();
	}
	public function listarAction(){

		$this->auth();
		$this->getTable()
			->getApiModel();
		$params = $this->getRequest()->getPost();
		$Source = $this->table->setTableModel($this->apiModel)
			->getSelect($params->toArray());
        if($this->tenancy):
		$Source->where(new In('empresa',$this->user->restrito));
        endif;
		$this->apiModel->setAdapter($this->getAdapter())
			->setSource($Source)
				->setUser($this->user)
					->setParamAdapter($params);

		$view = $this->apiModel->render();
		//$view = $this->apiModel->render('custom',sprintf('admin/cidade/%s/listar', LAYOUT));
		//$view = $this->apiModel->render('dataTableAjaxInit');
		//$view = $this->apiModel->render('dataTableJson');
		//$view = $this->apiModel->render('newDataTableJson');
		$view->setVariable('route',$this->route);
		$view->setVariable('controller',$this->controller);
		return $view;
	}

	public function createAction(){
		$this->auth();
		if(!$this->getRequest()->isPost()):
			$this->args['msg'] = sprintf("Nenhuma model valida foi passada <b>%s</b>!", $this->user['first_name']);
			return new JsonModel($this->args);
		endif;
		if (!$this->model):
			$this->args['msg'] = sprintf("Nenhuma model valida foi passada <b>%s</b>!", $this->user['first_name']);
			return new JsonModel($this->args);
		endif;
		if (!$this->table):
			$this->args['msg'] = sprintf("Nenhuma table valida foi passada <b>%s</b>!", $this->user['first_name']);
			return new JsonModel($this->args);
		endif;
		$this->getModel()->getTable();
		$this->model->offsetSet('empresa', $this->user->empresa);
		$this->args = array_merge($this->args, $this->table->insert($this->model));
		if ($this->args['result']):
			$this->args['redirect'] = $this->url()->fromRoute($this->route,[
				'controller' => $this->controller,
				'action'=>'editar',
				'id'=>$this->args['result']
			]);
		endif;
		return new JsonModel($this->args);
	}
	public function editarAction(){
		$view = new ViewModel([
			'route'=>$this->route,
			'controller'=>$this->controller
		]);
		return $view;
	}
	public function editarformAction()
	{
		$view = new ViewModel([
			'route'=>$this->route,
			'controller'=>$this->controller
		]);
		if (!$this->model):
			$this->args['msg'] = sprintf("Nenhuma model valida foi passada <b>%s</b>!", $this->user['first_name']);
		elseif (!$this->table):
			$this->args['msg'] = sprintf("Nenhuma table valida foi passada <b>%s</b>!", $this->user['first_name']);
		elseif (!$this->form):
			$this->args['msg'] = sprintf("Nenhum form valido foi passada <b>%s</b>!", $this->user['first_name']);
		else:
			$id = $this->params()->fromRoute("id",0);
			$this->setData()->getTable()->getModel();
			if ((int)$id):
				$this->model->exchangeArray($this->table->find($id));
				$this->getForm();
			else:
				$this->getForm();
				$this->store();
			endif;
		endif;
		$view->setTerminal(true);
		$view->setTemplate(sprintf($this->templateEdit, LAYOUT));
		$view->setVariable('form', $this->form);
		return $view;
	}

	public function store()
	{
		if($this->getRequest()->isPost()):
			//setamos o adapter no model
			$this->form->setInputFilter($this->model->getInputFilter());
			if ($this->form->isValid()):
				//validamos a model
				$this->args = array_merge($this->args, $this->table->save($this->model));
				$this->helper->addMessage($this->args['msg'],$this->args['type']);
				else:
				d($this->form->getMessages());
			endif;
			return new JsonModel($this->args);
		endif;
	}

	public function deleteAction()
	{
		if(!$this->params()->fromPost()):
			return $this->redirect()->toRoute($this->route,['controller'=>$this->controller]);
		endif;
		$this->getTable();
		$Resul = $this->table->delete($this->params()->fromPost('id'));
		return new JsonModel($Resul);
	}

	public function stateAction()
	{
		if(!$this->params()->fromPost()):
			return $this->redirect()->toRoute($this->route,['controller'=>$this->controller]);
		endif;
		$this->getTable();
		$Resul = $this->table->state(['status'=>$this->params()->fromRoute('id')], $this->params()->fromPost('id'));
		return new JsonModel($Resul);
	}

	public function uploadAction(){
		$data = $this->params()->fromFiles();
		$id = $this->params()->fromRoute("id",0);
		$ImagesUpload = $this->container->get(\Core\Service\ImagesUpload::class);
		$ImagesUpload->setBasePath($this->getRequest()->getServer('DOCUMENT_ROOT'));;
		$Result =  $ImagesUpload->persistFile($data['file'],[
			'controller'=>$this->controller,
			'id'=>$id
		]);
		return new JsonModel($Result);

	}

	public function galleryAction(){

		$id = $this->params()->fromRoute("id",0);
		if (!(int)$id):
			return new JsonModel([]);
		endif;
		$this->getTable();
		/**
		 * @var $GalleryTable GalleryTable
		 */
		$GalleryTable = $this->container->get(GalleryTable::class);
		/**
		 * @var $GalleryModel GalleryModel
		 */
		$GalleryModel = $this->container->get(GalleryModel::class);
		/**
		 * @var $GalleryForm GalleryForm
		 */
		$GalleryForm = $this->container->get(GalleryForm::class);

		$Data = $this->table->find($id);
		$GalleryForm->setBasePath($this->getRequest()->getServer('DOCUMENT_ROOT'));
		$GalleryForm->setInputFilter($GalleryForm->addInputFilter($this->controller,$id));
		$Files = $this->params()->fromFiles();
		if($Files):

				// Get the list of already saved files.
			$Files['file'][0]['name'] = $GalleryForm->setFileName($Files['file'][0]['name']);
				// Pass data to form.
				$GalleryForm->setData($Files);
				// Validate form.
				if($GalleryForm->isValid()) {
					// Move uploaded file to its destination directory.
					$GalleryForm->getData();
					$GalleryModel->offsetSet("name",substr($Files['file'][0]['name'], 0, strrpos($Files['file'][0]['name'], '.')));
					$GalleryModel->offsetSet('parent', $this->controller);
					$GalleryModel->offsetSet('parent_id',$id);
					$GalleryModel->offsetSet('status','1');
					//$GalleryModel->offsetSet('empresa',$this->user->empresa);
					$GalleryModel->offsetSet('cover',$Files['file'][0]['name']);
					$GalleryModel->offsetSet('path_upload',$GalleryForm->getSend());
					$GalleryTable->insert($GalleryModel);
				}

		endif;

		return new JsonModel($this->params()->fromFiles());
	}

	public function listgalleryAction(){
		$Gallerys=[];
		$datasUrl=[];
		$id = $this->params()->fromRoute("id",0);
		if (!(int)$id):
			return new JsonModel([]);
		endif;
		$this->imageManager = $this->container->get(ImageManager::class);
		/**
		 * @var $GalleryTable GalleryTable
		 */
		$GalleryTable = $this->container->get(GalleryTable::class);
		$Datas = $GalleryTable->select(['parent'=>$this->controller,'parent_id'=>$id]);
		if($Datas):
			foreach ($Datas as $data):
				$this->imageManager->setSaveToDir(sprintf("%s/%s/",$this->getRequest()->getServer('DOCUMENT_ROOT'),$data['path_upload']));
				// Get path to image file.
				$fileName = $this->imageManager->getImagePathByName($data['cover']);
				// Get image file info (size and MIME type).
				$fileInfo = $this->imageManager->getImageFileInfo($fileName);
				if ($fileInfo===false) {
					$fileInfo['type']="";
					$fileInfo['size']="";
					$fileInfo['width']="";
					$fileInfo['height']="";
				}
				$Gallerys[]=[
					'caption'=>$data['name'],
					//'downloadUrl'=>sprintf("/%s/%s",$data['path_upload'], $data['cover']),
					'url'=>$this->url()->fromRoute($this->route,[
						'controller' => $this->controller,
						'action'=>'delete-gallery-item',
						'id'=>$data['id']
					]),
					'size'=>$fileInfo['size'],
					'width'=>$fileInfo['width'],
					'key'=>$data['id'],
				];
		    $datasUrl[]=sprintf("/%s/%s",$data['path_upload'], $data['cover']);
			endforeach;
		endif;
		return new JsonModel([
			'info'=>$Gallerys,
			'datasUrl'=>$datasUrl,
		]);
	}

	public function deletegalleryitemAction(){
		$id = $this->params()->fromRoute("id",0);
		if (!(int)$id):
			return new JsonModel($this->args);
		endif;
		/**
		 * @var $GalleryTable GalleryTable
		 */
		$GalleryTable = $this->container->get(GalleryTable::class);
		$Data = $GalleryTable->find($id);
		$this->args = array_merge($this->args, $GalleryTable->delete(['id'=>[$this->params()->fromRoute('id')]]));
		if($this->args['result']):
			unlink(sprintf("%s/%s/%s", $this->getRequest()->getServer('DOCUMENT_ROOT'),$Data['path_upload'], $Data['cover']));
		endif;
		return new JsonModel($this->args);
	}
	public function deletegalleryAction(){

		return new JsonModel($this->params()->fromPost());
	}

	public function fileAction(){
//      Get the file name from GET variable.
		$fileName = $this->params()->fromQuery('name', '/dist/uploads/images/no_image.jpg');

		// Check whether the user needs a thumbnail or a full-size image.
		$isThumbnail = (bool)$this->params()->fromQuery('thumbnail', false);

		$this->imageManager = $this->container->get(ImageManager::class);
		$this->imageManager->setSaveToDir($this->getRequest()->getServer('DOCUMENT_ROOT'));
		// Get path to image file.
		$fileName = $this->imageManager->getImagePathByName($fileName);
		if($isThumbnail) {
			$desiredWidth = $this->params()->fromQuery('w', 240);
			// Resize the image.
			$fileName = $this->imageManager->resizeImage($fileName,$desiredWidth);
		}

		// Get image file info (size and MIME type).
		$fileInfo = $this->imageManager->getImageFileInfo($fileName);
		if ($fileInfo===false) {
			// Set 404 Not Found status code
			$fileInfo = $this->imageManager->getImageFileInfo('/dist/uploads/images/no_image.jpg');
		}

		// Write HTTP headers.
		$response = $this->getResponse();
		$headers = $response->getHeaders();
		$headers->addHeaderLine("Content-type: " . $fileInfo['type']);
		$headers->addHeaderLine("Content-length: " . $fileInfo['size']);

		// Write file content.
		$fileContent = $this->imageManager->getImageFileContent($fileName);
		if($fileContent!==false) {
			$response->setContent($fileContent);
		} else {
			// Set 500 Server Error status code.
			$this->getResponse()->setStatusCode(500);
			return;
		}

		if($isThumbnail) {
			// Remove temporary thumbnail image file.
			unlink($fileName);
		}

		// Return Response to avoid default view rendering.
		return $this->getResponse();
	}

	public function uploadmodalAction(){
		$view = new ViewModel([
			'route'=>$this->route,
			'controller'=>$this->controller
		]);
		$this->getTable();
		$id = $this->params()->fromRoute("id",0);
		$Imagem[$this->cover]="/dist/uploads/images/no_image.jpg";
		if ((int)$id):
			$Imagem = $this->table->find($id);
		endif;
		// Get the list of already saved files.
		$file = $Imagem[$this->cover];
		$data[$this->cover] = $file;
		$view->setTerminal(true);
		$view->setVariable('file',$file);
		$view->setVariable('data', $data);
		$view->setTemplate(sprintf("core/%s/modal/default", LAYOUT));
		return $view;
	}
	/**
	 * @return $this
	 */
	public function getForm()
	{
		$this->form = $this->container->get($this->form);
		if($this->model instanceof AbstractModel):
			$this->form->setData($this->model->getArrayCopy());
		endif;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function getModel()
	{
		$this->model = $this->container->get($this->model);
		$this->model->exchangeArray($this->data);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function getTable()
	{
		$this->table = $this->container->get($this->table);
		return $this;
	}

	/**
	 * @return \Core\AbstractTable
	 */
	public function getApiModel()
	{
		$this->apiModel = $this->container->get($this->apiModel);
		return $this;
	}

	public function setData()
	{
		$this->data = $this->params()->fromPost();
		unset($this->data['submit']);
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getHelper()
	{
		$this->helper = new Messages();
		return $this;
	}

	/**
	 * @return AdapterInterface
	 */
	public function getAdapter()
	{
		$this->adapter = $this->container->get(AdapterInterface::class);
		return $this->adapter;
	}


	/**
	 * @return \Zend\Http\Response
	 */
	protected function auth(){
		if(!$this->identity()):
			return $this->redirect()->toRoute("auth");
		endif;
		$this->user = $this->identity();
	}
	protected function quest(){
		if($this->identity()):
			return $this->redirect()->toRoute("admin");
		endif;
	}




}
