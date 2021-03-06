<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Api\Model;


use Admin\Table\RoleTable;
use Core\AbstractTable;
use Zend\Db\Sql\Select;

class User extends AbstractTable
{
	protected $config = [
		'name' => 'Lista de usuarios',
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
		'Controller' => 'user',
		'numberColls' => 3,
		'rowAction' => ''
	];

	/**
	 * @var array Definition of headers
	 */
	protected $headers = [
		'id' => ['title' => 'check-all', 'width' => '50'],
		'cover' => ['title' => 'Avatar', 'width' => '50'],
		'first_name' => ['title' => 'Nome\Descrição'],
		'email' => ['title' => 'E-Mail', 'width' => 180],
		'access' => ['title' => 'Nivel\Acesso', 'width' => 180],
		'status' => ['title' => 'Active' , 'width' => 100],
	];

	public function init()
	{
		//zf-init-cover
		$this->getHeader('cover')->getCell()->addDecorator('img', [
			'base' => $this->getUrl('admin/default', [
				'controller'=>'user',
				'action'=>'file'
			]),
			'vars' => ['cover'],
			//'attrs' => ['class'=>'img-circle','style'=>'width: 100%; display: block;']
			'attrs' => ['class'=>'img-circle'],
			'thumbnail'=>true
		]);
		$this->getHeader('first_name')->getCell()->addDecorator('callable', [
			'callable' => function($context, $record){
				return sprintf("%s %s", $context, $record['last_name']);
			}
		]);
		$this->getHeader('first_name')->getCell()->addDecorator('link', [
			'url' =>  $this->getUrl('admin/default', [
				'controller'=>'user',
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
		$this->getHeader('access')->getCell()->addDecorator('callable', [
			'callable' => function($context, $record){
				if((int)$context):
					$Role = $this->container->get(RoleTable::class);
					$Result = $Role->find((int)$context);
					return $Result['name'];
				endif;
				return $context;
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

		$this->getHeader('id')->getCell()->addDecorator('check')->addCondition('acl', [
			'acl' => $this->acl->getAcl(),
			'role' => $this->user->access,
			'params' => $this->getRoute()->getParans(),
			'action' => 'state',
		]);
		$this->getHeader('id')->addDecorator('check');
	}

	/**
	 * @param Select $query
	 */
	protected function initFilters(Select $query)
	{

	}
}