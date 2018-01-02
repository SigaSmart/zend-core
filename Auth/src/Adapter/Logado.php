<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 30/12/2017
 * Time: 13:16
 */

namespace Auth\Adapter;


use Core\Table\AbstractTable;

class Logado extends AbstractTable
{

	protected $table = "users";

	public function user($id){

		return $this->findObject($id,['id','empresa','first_name','last_name','cover','access','email','created_at','updated_at']);

	}
}