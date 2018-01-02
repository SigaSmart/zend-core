<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Api\Model;


use Core\AbstractTable;
use Zend\Db\Sql\Select;

class Empresa extends AbstractTable
{
	protected $config = [
		'name' => 'Titulo Da Tabela',
		'showPagination' => true,
		'showQuickSearch' => true,
		'showItemPerPage' => true,
		'itemCountPerPage' => 12,
		'showColumnFilters' => true,
		'showExportToCSV' => true,
		'valuesOfItemPerPage' => [6, 12, 24, 48 , 96 , 192],
		//'valuesOfItemPerPage' => array(5, 10, 20, 50 , 100 , 200),
		'showButtonsActions' => true,
		'valueButtonsActions' => ['add'=>"Adicionar",'active'=>'Ativar','inactive'=>"Desabilitar","trash"=>"Enviar p/ Lixeira",'trashall'=>'Esvaziar Lixeira','csv'=>'Exportar'],
		'Module' => 'Admin',
		'Route' => 'admin',
		'Controller' => 'cidade',
		'numberColls' => 3,
		'rowAction' => ''
	];

	/**
	 * @var array Definition of headers
	 */
	protected $headers = [
		'id' => ['title' => 'check-all', 'width' => '50'],
		'cover' => ['title' => 'Imagem', 'width' => 100],
		'social' => ['title' => 'Name'],
		'tipo' => ['title' => 'Tipo', 'width' => 90],
		'phone' => ['title' => 'Telefone', 'width' => 120],
		'phone' => ['title' => 'Telefone', 'width' => 120],
		'email' => ['title' => 'E-Mail', 'width' => 130],
		'cnpj' => ['title' => 'Cnpj', 'width' => 120],
		'status' => ['title' => 'Active' , 'width' => 100],
	];

	public function init()
	{
		$this->getHeader('cover')->getCell()->addDecorator('img', [
					'base' => $this->getUrl('admin/default', [
						'controller'=>'empresa',
						'action'=>'file'
					]),
					'vars' => ['cover'],
					//'attrs' => ['class'=>'img-circle','style'=>'width: 100%; display: block;']
					'attrs' => ['class'=>'img-circle'],
					'thumbnail'=>true,
					'w'=>50
				]);
		
		$this->getHeader('social')->getCell()->addDecorator('link', [
			'url' =>  $this->getUrl('admin/default', [
				'controller'=>'empresa',
				'action'=>'editar',
				'id' => "%s"
			]),
			'vars' => ['id'],
		])->addCondition('equal', ['column' => 'status', 'values' => '1']);
		$this->getHeader('tipo')->getCell()->addDecorator('mapper', [
				'1' => 'Matriz',
				'2' => 'Filial'
		]);
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