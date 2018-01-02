<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 29/12/2017
 * Time: 20:37
 */

namespace Auth\Adapter;


use Core\Table\AbstractTable;
use Zend\Db\Sql\Predicate\In;
use Zend\Db\Sql\Predicate\IsNotNull;

class Company extends AbstractTable
{
	protected $table = "empresa";

	protected $restrito=[];

	public function matriz($id){
		$Result = $this->find($id);
		$this->restrito[$Result['id']] = $id;
		if($Result):
			if($Result['tipo']=="1"):
				$this->filiais($id);
			endif;
		endif;
		return $Result;
	}
	public function filiais($id){
		$this->getSelect()->where(new In('empresa',[$id]));
		//$this->Select->where(new IsNotNull('empresa'));
		$this->setStmt($this->getSql()->prepareStatementForSqlObject($this->Select));
		$this->exec();
		if($this->getResultSet()->count()):
			$Data = $this->getResultSet()->toArray();
		   	$this->setRestrito($Data);
		endif;
	}

	/**
	 * @param $restrito
	 *
	 * @return $this
	 */
	public function setRestrito($restrito){
		foreach ($restrito as $item):
			$this->restrito[$item['id']] = $item['id'];
		endforeach;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getRestrito(): array
	{
		return $this->restrito;
	}

}