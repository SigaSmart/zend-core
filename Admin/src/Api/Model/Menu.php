<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Api\Model;


use Admin\Table\MenuTable;
use Core\AbstractTable;
use Zend\Db\Sql\Select;

class Menu extends AbstractTable
{
	protected $config = [
		'name' => 'Lista de menus',
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
		'Controller' => 'menu',
		'numberColls' => 3,
		'rowAction' => ''
	];

	/**
	 * @var array Definition of headers
	 */
	protected $headers = [
		'id' => ['title' => 'check-all', 'width' => '50'],
		'name' => ['title' => 'Nome\Descrição'],
		'parent' => ['title' => 'Grupo','separatable' => true],
		'alias' => ['title' => 'Class\Controller'],
		'status' => ['title' => 'Active' , 'width' => 100],
	];

	public function init()
	{
		//zf-init-cover
		
		$this->getHeader('name')->getCell()->addDecorator('link', [
			'url' =>  $this->getUrl('admin/default', [
				'controller'=>'menu',
				'action'=>'editar',
				'id' => "%s"
			]),
			'vars' => ['id'],
		])->addCondition('equal', ['column' => 'status', 'values' => '1']);

		$this->getHeader('parent')->getCell()->addDecorator('callable', [
			'callable' => function($context, $record){
				$Menu = $this->container->get(MenuTable::class);
				if((int)$context):
					$Result = $Menu->find((int)$context);
					return $Result['name'];
				endif;
				return sprintf("Menu Principal: %s",$record['name']);
			}
		]);
		$this->getRow()->addDecorator('separatable', ['defaultColumn' => 'parent']);
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
     $query->order(['parent'=>"ASC"]);
	}
}