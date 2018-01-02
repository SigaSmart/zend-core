<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 02/01/2018
 * Time: 13:54
 */

namespace Webblog\Controller;


use Blog\Table\PostsTable;
use Core\Controller\AbstractController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractController
{

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
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

		]);
		$data = $this->table->select(['status'=>'1']);
		return new ViewModel([
			'data'=>$data
		]);
	}
	public function postsAction(){
		$this->table = PostsTable::class;
		$this->getTable();
		$this->table->setJoin([
			'users'=>[
				'key'=>'author',
				'parent'=>'id',
				'c'=>['first_name','last_name']
			],

		]);
		$data = $this->table->select(['status'=>'1']);
		return new ViewModel([
			'data'=>$data
		]);
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
	public function aboutAction(){

	}
	public function contactAction(){

	}
}