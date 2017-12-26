<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Api\Model;


use Core\AbstractTable;
use Zend\Db\Sql\Select;

class Resource extends AbstractTable
{
	protected $config = [
		'name' => 'Lista de modulos',
		'showPagination' => true,
		'showQuickSearch' => true,
		'showItemPerPage' => true,
		'itemCountPerPage' => 12,
		'showColumnFilters' => true,
		'showExportToCSV' => true,
		'valuesOfItemPerPage' => [6, 12, 24, 48 , 96 , 192],
		'showButtonsActions' => true,
		'valueButtonsActions' => ['add'=>"Adicionar",'active'=>'Ativar','inactive'=>"Desabilitar","trash"=>"Enviar p/ Lixeira",'trashall'=>'Esvaziar Lixeira','csv'=>'Exportar'],
		'Module' => 'Admin',
		'Route' => 'admin',
		'Controller' => 'resource',
		'numberColls' => 3,
		'rowAction' => ''
	];

	/**
	 * @var array Definition of headers
	 */
	protected $headers = [
		'id' => ['title' => 'check-all', 'width' => '50'],
		'name' => ['title' => 'Nome\Descrição'],
		'alias' => ['title' => 'Nome\Real', 'width' => 180],
		'route' => ['title' => 'Rota', 'width' => 160],
		'status' => ['title' => 'Active' , 'width' => 100],
	];

	public function init()
	{
		//zf-init-cover
		
		$this->getHeader('name')->getCell()->addDecorator('link', [
			'url' =>  $this->getUrl('admin/default', [
				'controller'=>'resource',
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