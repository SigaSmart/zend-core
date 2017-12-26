<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Table;


use Core\Model\AbstractModel;
use Core\Table\AbstractTable;

class ProdutoTable extends AbstractTable
{

	protected $table = 'produtos';
	public function insert(AbstractModel $mode) {
		$mode->offsetSet('name', "Novo Produto");
		$mode->offsetSet('created_at', date("Y-m-d H:i:s"));
		$mode->offsetSet('updated_at', date("Y-m-d H:i:s"));
		//Descomentar se ouver url amigavel
        //$mode->offsetSet('alias', $this->slugExists('alias', $mode->offsetGet("name"), $mode->offsetGet("id")));
      	return parent::insert($mode);
	}

   public function save(AbstractModel $mode) {
        $mode->offsetSet('updated_at', date("Y-m-d H:i:s"));
        //Descomentar se ouver url amigavel
        //$mode->offsetSet('alias', $this->slugExists('alias', $mode->offsetGet("name"), $mode->offsetGet("id")));
        //$this->Result['inputs'] = [
        //    'alias' => $mode->offsetGet('alias')
        //];
        return parent::save($mode);
    }

}