<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Blog\Table;


use Core\Model\AbstractModel;
use Core\Table\AbstractTable;

class CategorieTable extends AbstractTable
{

	protected $table = 'categories';
	public function insert(AbstractModel $mode) {
		$mode->offsetSet('name', "Nova Categorie");
		$mode->offsetSet('created_at', date("Y-m-d H:i:s"));
		$mode->offsetSet('updated_at', date("Y-m-d H:i:s"));
		//Descomentar se ouver url amigavel
        $mode->offsetSet('alias', $this->slugExists('alias', $mode->offsetGet("name"), $mode->offsetGet("id")));
      	return parent::insert($mode);
	}

   public function save(AbstractModel $mode) {
        $mode->offsetSet('updated_at', date("Y-m-d H:i:s"));
        //Use para atualizar data erradas depois coment ou apague
        $mode->offsetSet('created_at', date("Y-m-d H:i:s"));
        //Descomentar se ouver url amigavel
        $mode->offsetSet('alias', $this->slugExists('alias', $mode->offsetGet("name"), $mode->offsetGet("id")));
        return parent::save($mode);
    }

}