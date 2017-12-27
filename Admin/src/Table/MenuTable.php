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
	private $submenus;
	private $menus;

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

	public function getMenus() {
		$this->menus = $this->getSelect(['status' => '1'])->where( new \Zend\Db\Sql\Predicate\IsNull('parent'));
		$this->menus->order(['ordem'=>'ASC']);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($this->menus);
		$this->exec();
		if ($this->resultSet->count()):
			$Menus = $this->resultSet->toArray();
			if($Menus):
				foreach ($Menus as $key => $menu):
					$this->submenus = $this->getSelect(['parent' => $menu['id'], 'status' => '1'])->where( new \Zend\Db\Sql\Predicate\IsNotNull('parent'));
					$this->submenus->order(['ordem'=>'ASC']);
					$this->Stmt = $this->Sql->prepareStatementForSqlObject($this->submenus);
					$this->exec();
					if ($this->resultSet->count()):
						$SubMenus = $this->resultSet->toArray();
						if($SubMenus):
							$Menus[$key]['pages']= $SubMenus;
						endif;
					endif;
				endforeach;
				return $Menus;
			endif;
		endif;
		return [];
	}

}				