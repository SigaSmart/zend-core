<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 18/12/2017
 * Time: 18:27
 */

namespace Core\Table;


use Core\Model\AbstractModel;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\StatementInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;

class AbstractTable extends Utils
{


	/**
	 * @var \Zend\Db\Adapter\AdapterInterface
	 */
	protected $adapter;

	/**
	 * @var Sql
	 */
	protected $Sql;

	/**
	 * @var array
	 */
	protected $join=[];

	/**
	 *
	 * @var StatementInterface
	 */
	protected $Stmt;

	/**
	 * @var string
	 */
	protected $table;

	/**
	 *
	 * @var ResultSet
	 */
	protected $resultSet;

	/**
	 *
	 * @var \Zend\Db\Sql\Select
	 */
	protected $Select;

	/**
	 * @var string
	 */
	protected $id = "id";

	/**
	 * @var string|array
	 */
	protected $where;

	/**
	 * @var array
	 */

	protected $Result = [
		'result' => FALSE,
		'type' => "danger",
		'msg' => ""
	];
	/**
	 *
	 * @var AbstractModel
	 */
	protected $model;
	protected $Model;
	protected $tableModel;
	protected $paginator;

	/**
	 * @param mixed $tableModel
	 *
	 * @return AbstractTable
	 */
	public function setTableModel($tableModel)
	{
		$this->tableModel = $tableModel;
		return $this;
	}


	/**
	 * AbstractTable constructor.
	 *
	 * @param AdapterInterface $adapter
	 */
	public function __construct(AdapterInterface $adapter)
	{
		$this->Sql = new Sql($adapter);
		$this->adapter = $adapter;
	}


	/**
	 * @param array $join
	 * @return $this
	 */
	public function setJoin(array $join)
	{
		$this->join = $join;
		return $this;
	}

	/**
	 * @param array $where
	 * @param null  $table
	 * @param array $colluns
	 *
	 * @return \Zend\Db\Sql\Select
	 */
	public function getSelect($where = [], $table = null, $colluns = ['*']) {
		$this->Select = $this->Sql->select();
		if ($table):
			$this->table = $table;
		endif;
		if ($this->join):
			foreach ($this->join as $key => $jon):
				$this->Select->join([$key => $key],        // join table with alias
					sprintf('%s.%s = %s.%s',$this->table,$jon['key'],$key,$jon['parent']),  // join expression
					$jon['c'],
					$this->Select::JOIN_INNER
				);
			endforeach;
		endif;
		$this->filtro($where);
		$this->Select->from($this->table)->columns($colluns);
		$this->Select->where($this->where);
		$this->Select->limit(1000);
		return $this->Select;
	}


	/**
	 * @param array $where
	 * @param null  $table
	 * @param array $colluns
	 *
	 * @return array
	 */
	public function select($where = [], $table = null, $colluns = ['*']) {
		$this->Select = $this->Sql->select();
		if ($table):
			$this->table = $table;
		endif;
		if ($this->join):
			foreach ($this->join as $key => $jon):
				$this->Select->join([$key => $key],        // join table with alias
					sprintf('%s.%s = %s.%s',$this->table,$jon['key'],$key,$jon['parent']),  // join expression
					$jon['c'],
					$this->Select::JOIN_INNER
				);
			endforeach;
		endif;
		$this->filtro($where);
		$this->Select->from($this->table)->columns($colluns);
		$this->Select->where($this->where);
		$this->Select->offset($this->offset);
		$this->Select->limit($this->limit);
		$this->Select->order($this->order);

		$this->Stmt = $this->Sql->prepareStatementForSqlObject($this->Select);
		$this->exec();
		if ($this->resultSet->count()):
			return $this->resultSet->toArray();
		endif;
		return [];
	}

	/**
	 * @return array
	 */
	public function all() {
		$this->Select = $this->Sql->select()->from($this->table);
		$this->Select->limit(1000);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($this->Select);
		$this->exec();
		if ($this->resultSet->count()):
			return $this->resultSet->toArray();
		endif;
		return [];
	}

	/**
	 * @param int   $id
	 * @param array $colluns
	 *
	 * @return array
	 */
	public function find(int $id, $colluns = ['*']) {
		$this->Select = $this->Sql->select();
		$this->Select->from([$this->table => $this->table]);
		if ($this->join):
			foreach ($this->join as $key => $jon):
				$this->Select->join([$key => $key],        // join table with alias
					sprintf('%s.%s = %s.%s',$this->table,$jon['key'],$key,$jon['parent']),  // join expression
					$jon['c'],
					$this->Select::JOIN_INNER
				);
			endforeach;
		endif;
		$this->Select->columns($colluns);
		$this->Select->where(["{$this->table}.{$this->id}" => $id]);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($this->Select);
		$this->exec();
		if ($this->resultSet->count()):
			return $this->resultSet->current()->getArrayCopy();
		endif;
		return [];
	}
	/**
	 * @param int   $id
	 * @param array $colluns
	 *
	 * @return array
	 */
	public function findObject(int $id, $colluns = ['*']) {
		$this->Select = $this->Sql->select();
		$this->Select->from([$this->table => $this->table]);
		if ($this->join):
			foreach ($this->join as $key => $jon):
				$this->Select->join([$key => $key],        // join table with alias
					sprintf('%s.%s = %s.%s',$this->table,$jon['key'],$key,$jon['parent']),  // join expression
					$jon['c'],
					$this->Select::JOIN_INNER
				);
			endforeach;
		endif;
		$this->Select->columns($colluns);
		$this->Select->where(["{$this->table}.{$this->id}" => $id]);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($this->Select);
		$this->exec();
		if ($this->resultSet->count()):
			return $this->resultSet->current();
		endif;
		return null;
	}

	/**
	 * @param array $where
	 * @param array $colluns
	 *
	 * @return array
	 */
	public function findBy(array $where, $colluns = ['*']) {
		$this->Select = $this->Sql->select();
		$this->Select->from($this->table);
		if ($this->join):
			foreach ($this->join as $key => $jon):
				$this->Select->join([$key => $key],        // join table with alias
					sprintf('%s.%s = %s.%s',$this->table,$jon['key'],$key,$jon['parent']),  // join expression
					$jon['c'],
					$this->Select::JOIN_INNER
				);
			endforeach;
		endif;
		$this->Select->columns($colluns);
		$this->Select->where($where);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($this->Select);
		$this->exec();
		if ($this->resultSet->count()):
			return $this->resultSet->toArray();
		endif;
		return [];
	}

	/**
	 * @param array $where
	 * @param array $colluns
	 *
	 * @return array
	 */
	public function findOneBy(array $where, $colluns = ['*']) {
		$this->filtro($where);
		$this->Select = $this->Sql->select();
		$this->Select->from($this->table);
		if ($this->join):
			foreach ($this->join as $key => $jon):
				$this->Select->join([$key => $key],        // join table with alias
					sprintf('%s.%s = %s.%s',$this->table,$jon['key'],$key,$jon['parent']),  // join expression
					$jon['c'],
					$this->Select::JOIN_INNER
				);
			endforeach;
		endif;
		$this->Select->columns($colluns);
		$this->Select->where($this->where);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($this->Select);
		$this->exec();
		if ($this->resultSet->count()):
			return $this->resultSet->current()->getArrayCopy();
		endif;
		return [];
	}


	/**
	 * @param $condicao
	 *
	 * @return array|string|Where
	 */
	protected function filtro($condicao) {
		$this->where = new Where();
		if (isset($condicao['user'])) {
			$this->where->addPredicate(new Operator("{$this->table}.user", "=", $condicao['user']));
			unset($condicao['user']);
		}
		if ($this->Model instanceof AbstractModel) {

			if ($this->Model->offsetExists("empresa")) {
				if (is_array( $this->Model->offsetGet("empresa"))) {
					$this->where->in("{$this->table}.empresa",  $this->Model->offsetGet("empresa"));
				}
				else{
					if($this->table == "empresa"):
						$this->where->addPredicate(new Operator("{$this->table}.id", "=", $this->Model->offsetGet("empresa")));
					else:
						$this->where->addPredicate(new Operator("{$this->table}.empresa", "=", $this->Model->offsetGet("empresa")));
					endif;
				}
			}
		}

		if (isset($condicao['status']) && $condicao['status'] >= 0) {
			// $operator=$condicao['state']>=0?"=":">";
			$this->where->addPredicate(new Operator("{$this->table}.status", "=", $condicao['status']));
			unset($condicao['status']);
		}
		if (isset($condicao['valuesState']) && $condicao['valuesState'] > 0) {
			// $operator=$condicao['state']>=0?"=":">";
			$this->where->addPredicate(new Operator("{$this->table}.status", "=", $condicao['valuesState']));
			unset($condicao['valuesState']);
		}
		if (isset($condicao['zfTableQuickSearch']) && !empty($condicao['zfTableQuickSearch'])) {
			$colls = implode(", ", array_keys($this->tableModel->getHeaders()));
			$this->where->expression("CONCAT_WS(' ', {$colls}) LIKE ?", "%{$condicao['zfTableQuickSearch']}%");
			unset($condicao['zfTableQuickSearch']);
		}
		if ($this->like && !empty($this->value)) {
			$colls = implode(", ", array_keys($this->like));
			$this->where->expression("CONCAT_WS(' ', {$colls}) LIKE ?", "%{$this->value}%");
		}
		if ($condicao):
			unset($condicao['table_search'], $condicao['zfTablePage'], $condicao['zfTableColumn'], $condicao['zfTableOrder'], $condicao['zfTableQuickSearch'], $condicao['zfTableItemPerPage'], $condicao['valuesState'], $condicao['id']);
			foreach ($condicao as $key => $value):
				if (isset($value['index']) && isset($value['op']) && isset($value['value'])):
					$this->where->addPredicate(new Operator("{$this->table}.{$value['index']}", $value['op'], $value['value']));
				else:
					$this->where->addPredicate(new Operator("{$this->table}.{$key}", "=", $value));
				endif;
			endforeach;
		endif;
		return $this->where;
	}

	public function getPaginator($resultSetArray,$page=1, $countPerPage=12){
		$this->paginator = new \Zend\Paginator\Paginator(new
			\Zend\Paginator\Adapter\ArrayAdapter($resultSetArray)
		);
		$this->paginator->setCurrentPageNumber($page)
			->setItemCountPerPage($countPerPage);
		return $this->paginator;
	}

	//INSERT

	/**
	 * @param AbstractModel $mode
	 *
	 * @return array
	 */
	public function insert(AbstractModel $mode) {
		$Data = $this->clear($mode->getArrayCopy());
		$Query = $this->Sql->insert()
			->into($this->table)
			->columns(array_keys($Data))
			->values($Data);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($Query);
		$result = $this->finaliza("Registro Cadastrado Com Sucesso!");
		if($result):
			$this->Result['result'] = $result->getGeneratedValue();
		endif;
		return $this->Result;
	}

	/**
	 * @param AbstractModel $mode
	 *
	 * @return array
	 */
	public function save(AbstractModel $mode) {
		$Data = $this->clear($mode->getArrayCopy());
		if (isset($Data[$this->id])):
			$Query = $this->Sql->update()
				->table($this->table)
				->set($Data)
				->where([$this->id => $Data[$this->id]]);
			$this->Stmt = $this->Sql->prepareStatementForSqlObject($Query);
			$result = $this->finaliza("Registro Atualizado Com Sucesso!");
			if($result):
				$this->Result['result'] = $Data[$this->id];
			endif;
		else:
			$Query = $this->Sql->insert()
				->into($this->table)
				->columns(array_keys($Data))
				->values($Data);
			$this->Stmt = $this->Sql->prepareStatementForSqlObject($Query);
			$result = $this->finaliza("Registro Cadastrado Com Sucesso!");
			if($result):
				$this->Result['result'] = $result->getGeneratedValue();
			endif;
		endif;
		return $this->Result;
	}

	//DELETE

	/**
	 * @param array $where
	 *
	 * @return array
	 */
	public function delete(array $where) {
		$Query = $this->Sql->delete()
			->from($this->table)
			->where([$this->id => $where]);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($Query);
		$this->finaliza("Registro(s) Excluidos com sucesso!");
		return $this->Result;
	}

	public function update(array $values, array $where) {
		$Data = $this->clear($values);
		$Query = $this->Sql->update()
			->table($this->table)
			->set($Data)
			->where([$this->id => $where]);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($Query);
		$this->finaliza("Registro(s) Atualizado Com Sucesso!");
		return $this->Result;
	}

	public function state(array $values, array $where) {
		$Data = $this->clear($values);
		$Query = $this->Sql->update()
			->table($this->table)
			->set($Data)
			->where([$this->id => $where]);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($Query);
		$this->finaliza("Registro(s) Atualizado Com Sucesso!");
		return $this->Result;
	}
	/**
	 * @return $this
	 */
	protected function finaliza($msg) {
		$result = null;
		try {
			$result = $this->Stmt->execute();
			$this->Result['type'] = FlashMessenger::NAMESPACE_SUCCESS;
			$this->Result['result'] = TRUE;
			$this->Result['msg'] = $msg;
		} catch (\Exception $e) {
			$this->Result['type'] = FlashMessenger::NAMESPACE_ERROR;
			$this->Result['result'] = FALSE;
			$this->Result['msg'] = sprintf("OPSS! %s<br />%s!", $e->getCode(), $e->getMessage());
		}
		return $result;
	}
	/**
	 * @return $this
	 */
	public function exec() {
		$this->resultSet = new ResultSet();
		$this->resultSet->initialize($this->Stmt->execute());
		return $this;
	}

	/**
	 * @return array|string
	 */
	public function getWhere()
	{
		$this->where = new Where();
		return $this->where;
	}


	public function getAdapter(): AdapterInterface {
		return $this->adapter;
	}

	protected function slugify($string) {
		$slug = trim($string); // trim the string
		$slug = preg_replace('/[^a-zA-Z0-9 -]/', '', $slug); // only take alphanumerical characters, but keep the spaces and dashes too...
		$slug = str_replace(' ', '-', $slug); // replace spaces by dashes
		$slug = strtolower($slug);  // make it lowercase
		return $slug;
	}

	public function slugExists(string $SlugName, string $SlugValue, $SlugId = "") {
		$slug = $this->slugify($SlugValue);
		$this->Select = $this->Sql->select();
		$this->Select->from($this->table)
			->columns([$this->id => $this->id, 'count' => new Expression('COUNT(*)')]);
		$this->Select->where([$SlugName => (string) $slug]);
		$this->Stmt = $this->Sql->prepareStatementForSqlObject($this->Select);
		$this->exec();
		if ($this->resultSet->count()):
			$result = $this->resultSet->current()->getArrayCopy();
		endif;

		if (empty($SlugId)):
			if ($result['count']):
				$slug = sprintf("%s-%s", $slug, $result[$this->id]);
			endif;
		else:
			if ($result['count'] && $SlugId != $result[$this->id]):
				$slug = sprintf("%s-%s", $slug, $SlugId);
			endif;
		endif;
		return $slug;
	}

	/**
	 * @return Sql
	 */
	public function getSql(): Sql
	{
		return $this->Sql;
	}

	/**
	 * @param StatementInterface $Stmt
	 *
	 * @return AbstractTable
	 */
	public function setStmt(StatementInterface $Stmt): AbstractTable
	{
		$this->Stmt = $Stmt;
		return $this;
}

	/**
	 * @return ResultSet
	 */
	public function getResultSet(): ResultSet
	{
		return $this->resultSet;
	}
}