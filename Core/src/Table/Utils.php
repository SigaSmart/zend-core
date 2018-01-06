<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 18/12/2017
 * Time: 18:28
 */

namespace Core\Table;


class Utils
{

	const SUCCESS = 'success';
	const DANGER = 'danger';
	const ERROR = 'error';
	const INFO = 'info';


	/**
	 * @var int $offset
	 */
	protected $offset=0;
	/**
	 * @var int $limit
	 */
	protected $limit = 1000;
	/**
	 * @var array $like
	 */
	protected $like=[];

	/**
	 * @var string $value
	 */
	protected $value="";

	/**
	 * @var array $order
	 */
	protected $order = ['id'=>'DESC'];

	/**
	 * @return int
	 */
	public function getOffset(): int
	{
		return $this->offset;
	}

	/**
	 * @param int $offset
	 *
	 * @return Utils
	 */
	public function setOffset(int $offset)
	{
		$this->offset = $offset;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getLimit(): int
	{
		return $this->limit;
	}

	/**
	 * @param int $limit
	 *
	 * @return Utils
	 */
	public function setLimit(int $limit)
	{
		$this->limit = $limit;
		return $this;
	}



	public function clear($Data){
		if(is_array($Data)):
			return array_filter($Data);
		endif;
		return $Data;
	}

	/**
	 * @param array $like
	 *
	 * @return Utils
	 */
	public function setLike(array $like)
	{
		$this->like = $like;
		return $this;
	}

	/**
	 * @param string $value
	 *
	 * @return Utils
	 */
	public function setValue(string $value)
	{
		$this->value = $value;
		return $this;
	}

	/**
	 * @param array $order
	 *
	 * @return Utils
	 */
	public function setOrder(array $order)
	{
		$this->order = $order;
		return $this;
	}


}