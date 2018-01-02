<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Api\Model;


use Admin\Table\ResourceTable;
use Admin\Table\RoleTable;
use Core\AbstractTable;
use Zend\Db\Sql\Select;

class Privilege extends AbstractTable
{
	protected $config = [
		'name' => 'Lista de privilégios',
		'showPagination' => true,
		'showQuickSearch' => true,
		'showItemPerPage' => true,
		'itemCountPerPage' => 12,
		'showColumnFilters' => true,
		'showExportToCSV' => false,
		'valuesOfItemPerPage' => [6, 12, 24, 48 , 96 , 192],
		'showButtonsActions' => true,
		'valueButtonsActions' => ['add'=>"Adicionar",'active'=>'Ativar','inactive'=>"Desabilitar","trash"=>"Enviar p/ Lixeira",'trashall'=>'Esvaziar Lixeira','csv'=>'Exportar'],
		'Module' => 'Admin',
		'Route' => 'admin',
		'Controller' => 'privilege',
		'numberColls' => 3,
		'rowAction' => ''
	];

	/**
	 * @var array Definition of headers
	 */
	protected $headers = [
		'id' => ['title' => 'check-all', 'width' => '50'],
		'name' => ['title' => 'Nome\Descrição', 'width' => 200],
		'action' => ['title' => 'Privilégios'],
		'role' => ['title' => 'Acesso', 'width' => 130],
		'resource' => ['title' => 'Modulo', 'width' => 130],
		'status' => ['title' => 'Active' , 'width' => 100],
	];

	public function init()
	{
		//zf-init-cover
		$this->getHeader('name')->getCell()->addDecorator('link', [
			'url' =>  $this->getUrl('admin/default', [
				'controller'=>'privilege',
				'action'=>'editar',
				'id' => "%s"
			]),
			'vars' => ['id'],
		])->addCondition('equal', ['column' => 'status', 'values' => '1'])
			->addCondition('acl', [
				'acl' => $this->acl->getAcl(),
				'role' => $this->user->access,
				'params' => $this->getRoute()->getParans(),
				'action' => 'editar',
			]);
		$this->getHeader('action')->getCell()->addDecorator('callable', [
			'callable' => function($context, $record){
				return sprintf("%s , Adicional: %s",$record['parent'], $context);
			}
		]);
		$this->getHeader('role')->getCell()->addDecorator('callable', [
			'callable' => function($context, $record){
				$Role = $this->container->get(RoleTable::class);
				$Result = $Role->find($context);
			    return $Result['name'];
			}
		]);
		$this->getHeader('resource')->getCell()->addDecorator('callable', [
			'callable' => function($context, $record){
				$Resource = $this->container->get(ResourceTable::class);
				$Result = $Resource->find($context);
				return $Result['name'];
			}
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