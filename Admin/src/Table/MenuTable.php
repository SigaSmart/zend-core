<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Table;


use Core\Model\AbstractModel;
use Core\Table\AbstractTable;

class MenuTable extends AbstractTable
{

	protected $table = 'menus';
	public function insert(AbstractModel $mode) {
		$mode->offsetSet('name', "Novo Menu");
		$mode->offsetSet('created_at', date("Y-m-d H:i:s"));
		$mode->offsetSet('updated_at', date("Y-m-d H:i:s"));
		//Descomentar se ouver url amigavel
       // $mode->offsetSet('route', $this->slugExists('alias', $mode->offsetGet("name"), $mode->offsetGet("id")));
      	return parent::insert($mode);
	}

   public function save(AbstractModel $mode) {
        $mode->offsetSet('updated_at', date("Y-m-d H:i:s"));
        //Descomentar se ouver url amigavel
       // $mode->offsetSet('route', $this->slugExists('route', $mode->offsetGet("name"), $mode->offsetGet("id")));
       
        return parent::save($mode);
    }

}				