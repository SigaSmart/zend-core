<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/12/2017
 * Time: 00:30
 */

namespace Admin\Table;


use Core\Model\AbstractModel;
use Core\Table\AbstractTable;

class CidadeTable extends AbstractTable
{

	protected $table = 'cidades';
	public function insert(AbstractModel $mode) {
		$mode->offsetSet('title', "Novo Cidade");
		$mode->offsetSet('created_at', date("Y-m-d H:i:s"));
		$mode->offsetSet('updated_at', date("Y-m-d H:i:s"));
		return parent::insert($mode);
	}
}