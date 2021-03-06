<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Blog\Api\Model;


use Core\AbstractTable;
use Zend\Db\Sql\Select;

class Posts extends AbstractTable
{
	protected $config = [
		'name' => 'Lista de post',
		'showPagination' => true,
		'showQuickSearch' => true,
		'showItemPerPage' => true,
		'itemCountPerPage' => 12,
		'showColumnFilters' => true,
		'showExportToCSV' => true,
		'valuesOfItemPerPage' => [6, 12, 24, 48 , 96 , 192],
		'showButtonsActions' => true,
		'valueButtonsActions' => ['add'=>"Adicionar",'active'=>'Ativar','inactive'=>"Desabilitar","trash"=>"Enviar p/ Lixeira",'trashall'=>'Esvaziar Lixeira','csv'=>'Exportar'],
		'Module' => 'Blog',
		'Route' => 'blog',
		'Controller' => 'posts',
		'numberColls' => 3,
		'rowAction' => ''
	];

	/**
	 * @var array Definition of headers
	 */
	protected $headers = [
		'id' => ['title' => 'check-all', 'width' => '50'],
		'cover' => ['title' => 'Imagem' , 'width' => 100],
		'name' => ['title' => 'Nome\Descrição'],
		'status' => ['title' => 'Active' , 'width' => 100],
	];

	public function init()
	{
		//zf-init-cover
		$this->getHeader('cover')->getCell()->addDecorator('img', [
			'base' => $this->getUrl('blog/default', [
				'controller'=>'posts',
				'action'=>'file'
			]),
			'vars' => ['cover'],
			//'attrs' => ['class'=>'img-circle','style'=>'width: 100%; display: block;']
			'attrs' => ['class'=>'img-circle'],
			'thumbnail'=>true
		]);
		$this->getHeader('name')->getCell()->addDecorator('link', [
			'url' =>  $this->getUrl('blog/default', [
				'controller'=>'posts',
				'action'=>'editar',
				'id' => "%s"
			]),
			'vars' => ['id'],
		])->addCondition('equal', ['column' => 'status', 'values' => '1']);

		$this->getHeader('status')->getCell()->addDecorator('state', [
			'value' => [
				'1' => 'Active',
				'2' => 'Desactive',
				'3' => 'Trash',
			],
			'class' => [
				'1' => 'green',
				'2' => 'yellow',
				'3' => 'red',
			],
		]);

		$this->getHeader('id')->getCell()->addDecorator('check');
		$this->getHeader('id')->addDecorator('check');
	}

	/**
	 * @param Select $query
	 */
	protected function initFilters(Select $query)
	{

	}
}