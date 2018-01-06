<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 02/01/2018
 * Time: 13:54
 */

namespace Webblog\Controller;


use Blog\Table\CategorieTable;
use Blog\Table\PostsTable;
use Core\Controller\AbstractController;
use Core\Module;
use Interop\Container\ContainerInterface;
use Webblog\Form\ContactForm;
use Zend\Db\Sql\Predicate\In;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->itemPage = 6;
		$this->getHelper();
	}

	public function indexAction(){

		$this->table = PostsTable::class;
		$this->getTable();
		$this->table->setJoin([
			'users'=>[
				'key'=>'author',
				'parent'=>'id',
				'c'=>['first_name','last_name']
			],

		])->setLimit(4);
		$data = $this->table->select(['status'=>'1']);
		return new ViewModel([
			'data'=>$data
		]);
	}
	public function postsAction(){
		//pega o slug ou url amigavel
		$slug = $this->params()->fromRoute('slug', 'all');
		//pegamos o numero da paginação
		$this->page = $this->params()->fromRoute('page', 1);
		if($slug!="all"):
			//pegamos o serviço da categoria
			$this->table = CategorieTable::class;
			//carregamos a table de categorias
			$this->getTable();
			//aplicamos o filtro pela slug
			$Categorie = $this->table->findOneBy(['alias'=>$slug]);
			if(is_null($Categorie['parent'])):
				$Parents = $this->table->select(['status'=>'1', 'parent'=>$Categorie['id']],null,['id']);
				foreach ($Parents as $parent):
					$Parent[] = $parent['id'];
				endforeach;
				$Parent[] = $Categorie['id'];
			else:
				$Parent=[
					$Categorie['id'],
					$Categorie['parent'],
				];
			endif;
			$this->table = PostsTable::class;
			$this->getTable();
			$this->table->setJoin([
				'users'=>[
					'key'=>'author',
					'parent'=>'id',
					'c'=>['first_name','last_name']
				],

			]);
			$Post = $this->table->getSelect(['status'=>'1'],'posts');
			$Post->where(new In('categorie',$Parent));
			$Post->order(['id'=>'DESC']);
			$Result = $this->table->setStmt($this->table->getSql()->prepareStatementForSqlObject($Post));
			$Result->exec();
			$data = $this->table->getPaginator($Result->getResultSet()->toArray(),$this->page,$this->itemPage);
		else:
			$this->table = PostsTable::class;
			$this->getTable();
			$this->table->setJoin([
				'users'=>[
					'key'=>'author',
					'parent'=>'id',
					'c'=>['first_name','last_name']
				],

			]);
			$data = $this->table->getPaginator($this->table->select(['status'=>'1']),$this->page,$this->itemPage);
			$Categorie['name'] = "Todos os Posts";
		endif;
		$view = new ViewModel([
			'data'=>$data,
			'parent'=>$Categorie,
			'slug'=>$slug
		]);

		return $view;
	}

	public function pesquisaAction(){
		//pegamos o numero da paginação
		$this->page = $this->params()->fromRoute('page', 1);
		$Categorie['name'] = "Nada encontrado";
		if($this->params()->fromPost()):
			$this->table = PostsTable::class;
			$this->getTable();
			$this->table->setJoin([
				'users'=>[
					'key'=>'author',
					'parent'=>'id',
					'c'=>['first_name','last_name']
				],

			])->setLike(['name','preview','description'])->setValue($this->params()->fromPost('pesquisa',''));
			$data = $this->table->getPaginator($this->table->select(['status'=>'1']),$this->page,$this->itemPage);
			$Categorie['name'] = "Todos os Posts";
		endif;
		$view = new ViewModel([
			'data'=>$data,
			'parent'=>$Categorie,
			'slug'=>'all'
		]);
		$view->setTemplate("webblog/home/posts");
		return $view;
	}
	public function postAction(){
		$this->table = PostsTable::class;
		$this->getTable();
		$this->table->setJoin([
			'users'=>[
				'key'=>'author',
				'parent'=>'id',
				'c'=>['first_name','last_name']
			],

		]);
		$data = $this->table->findOneBy(['alias'=>$this->params()->fromRoute('slug')]);
		return new ViewModel([
			'data'=>$data
		]);
	}


	public function aboutsAction(){
		return new ViewModel([
			'data'=>[]
		]);
	}
	public function contactAction(){
		return new ViewModel([
			'data'=>[]
		]);
	}
	public function contactformAction(){
		$view =  new ViewModel([
			'data'=>[]
		]);
		$this->form = ContactForm::class;
		$this->setData()->getForm();
		if($this->params()->fromPost()):
			$this->form->setData($this->data);
			$this->form->setInputFilter($this->form->addInputFilter());
			if ($this->form->isValid()):
				    $this->data['sis'] = Module::SIS;
					$this->data['url'] = $this->getRequest()->getServer('HTTP_ORIGIN');
					$mail = new \Core\Service\Mail($this->container);
					
					$mail->setSubject("Contato do site: " .Module::SIS)
						->setTo($this->data['email'])
						->setData($this->data)
						->setViewTemplate('contact-user')
						->send();
					
					$mail->setSubject("Contato do site: " .Module::SIS)
						->setTo("contato@sigasmart.com.br")
						->setData($this->data)
						->setViewTemplate('contact')
						->send();
					$view->setTemplate("webblog/home/contact-success");
				$view->setVariable('data', $this->data);
				$this->helper->addMessage("OPSS! menssagem enviada com sucesso!",'success');
			else:
				$this->helper->addMessage("OPSS! Formulario invalido!",'error');
			endif;
		endif;
		$view->setTerminal(true);
		$view->setVariable('form', $this->form);
		return $view;
	}
}