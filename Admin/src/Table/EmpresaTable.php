<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Table;


use Core\Model\AbstractModel;
use Core\Table\AbstractTable;

class EmpresaTable extends AbstractTable
{

	protected $table = "empresa";

	public function insert(AbstractModel $mode)
	{
		$mode->offsetSet('social', "Nova Empresa");
		$mode->offsetSet('tipo', "2");
		$mode->offsetSet('created_at', date("Y-m-d H:i:s"));
		$mode->offsetSet('updated_at', date("Y-m-d H:i:s"));
		return parent::insert($mode);
	}

	public function save(AbstractModel $mode) {
		$mode->offsetSet('updated_at', date("Y-m-d H:i:s"));

		//Descomentar se ouver url amigavel
		// $mode->offsetSet('route', $this->slugExists('route', $mode->offsetGet("name"), $mode->offsetGet("id")));
		$Result = parent::save($mode);
        if($mode->offsetGet('tipo') == "1" && !(int)$mode->offsetGet('empresa')):
			$mode->offsetSet("empresa",$Result['result']);
			$Result = parent::save($mode);
		endif;
		return $Result;
	}
}