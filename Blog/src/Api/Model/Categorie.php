<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Blog\Api\Model;


use Core\AbstractTable;
use Zend\Db\Sql\Select;

class Categorie extends AbstractTable
{
	protected $config = [
		'name' => 'Lista as categorias do blog',
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
		'Controller' => 'categorie',
		'numberColls' => 3,
		'rowAction' => ''
	];

	/**
	 * @var array Definition of headers
	 */
	protected $headers = [
		'id' => ['title' => 'check-all', 'width' => '50'],
		'name' => ['title' => 'Nome\Descrição'],
		'parent' => ['title' => 'Sessão'],
		'status' => ['title' => 'Active' , 'width' => 100],
	];

	public function init()
	{
		//zf-init-cover

		$this->getHeader('name')->getCell()->addDecorator('link', [
			'url' =>  $this->getUrl('blog/default', [
				'controller'=>'categorie',
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

		$this->getHeader('parent')->getCell()->addDecorator('callable', [
			'callable' => function($context, $record){
				if($context):
					$Categorie = $this->container->get(\Blog\Table\CategorieTable::class);
					$Result = $Categorie->find($context);
					return $Result['name'];
				endif;
				return "---";
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

		$this->getHeader('id')->getCell()->addDecorator('check')
			->addCondition('acl', [
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