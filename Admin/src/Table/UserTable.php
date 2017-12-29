<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin\Table;


use Core\Model\AbstractModel;
use Core\Table\AbstractTable;
use Zend\Crypt\Key\Derivation\Pbkdf2;

class UserTable extends AbstractTable
{

	protected $table = 'users';
	public function insert(AbstractModel $mode) {
		$mode->offsetSet('first_name', "Novo User");
		$mode->offsetSet('created_at', date("Y-m-d H:i:s"));
		$mode->offsetSet('updated_at', date("Y-m-d H:i:s"));
		//Descomentar se ouver url amigavel
        //$mode->offsetSet('alias', $this->slugExists('alias', $mode->offsetGet("first_name"), $mode->offsetGet("id")));
      	return parent::insert($mode);
	}

   public function save(AbstractModel $mode) {
        $mode->offsetSet('updated_at', date("Y-m-d H:i:s"));
	   if(empty($mode->offsetGet('password'))):
		   $mode->offsetUnset('password');
	   else:
		   $mode->offsetSet("password" ,md5($this->encryptPassword($mode->offsetGet('email'),$mode->offsetGet('password'))));
	   endif;
        //Descomentar se ouver url amigavel
        //$mode->offsetSet('alias', $this->slugExists('alias', $mode->offsetGet("first_name"), $mode->offsetGet("id")));
        //$this->Result['inputs'] = [
        //    'alias' => $mode->offsetGet('alias')
        //];
        return parent::save($mode);
    }
	public function encryptPassword($email, $password)
	{
		return base64_encode(Pbkdf2::calc('sha256', $password, $email, 10000, strlen($password*2)));
	}
}