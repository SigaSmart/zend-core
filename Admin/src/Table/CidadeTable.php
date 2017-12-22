<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
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