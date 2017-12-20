<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 00:40
 */

namespace Admin\Api\Model;


use Core\AbstractTable;
use Zend\Db\Sql\Select;

class Cidade extends AbstractTable
{
	protected $config = array(
		'name' => 'Base table',
		'showPagination' => true,
		'showQuickSearch' => false,
		'showItemPerPage' => true,
		'itemCountPerPage' => 10,
		'showColumnFilters' => false,
		'showExportToCSV' => false,
		'valuesOfItemPerPage' => array(5, 10, 20, 50 , 100 , 200),
		'rowAction' => ''
	);

	/**
	 * @var array Definition of headers
	 */
	protected $headers = [
		'id' => ['title' => 'Id', 'width' => '50'],
		'title' => ['title' => 'Name'],
		'uf' => ['title' => 'Surname'],
		'ibge' => ['title' => 'ibge'],
		'cep' => ['title' => 'cep'],
		'status' => ['title' => 'Active' , 'width' => 100],
	];

	public function init()
	{

	}

	/**
	 * @param Select $query
	 */
	protected function initFilters(Select $query)
	{

	}
}