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
//		if(is_array($Data)):
//			return array_filter($Data);
//		endif;
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

	public function form_read($post) {
		//$res=str_replace ( ",", "", $post );
		return @number_format($post, 2, ",", ".");
	}

	public function form_w($post) {
		$source = array('.', ',');
		$replace = array('', '.');
		$valor = str_replace($source, $replace, $post); //remove os pontos e substitui a virgula pelo ponto
		return $valor; //retorna o valor formatado para gravar no banco
	}

	public function Calcular($v1, $v2, $op) {
		$v1 = str_replace(".", "", $v1);
		$v1 = str_replace(",", ".", $v1);
		$v2 = str_replace(".", "", $v2);
		$v2 = str_replace(",", ".", $v2);
		switch ($op) {
			case "+":
				$r = $v1 + $v2;
				break;
			case "-":
				$r = $v1 - $v2;
				break;
			case "*":
				$r = $v1 * $v2;
				break;
			case "%":
				$bs = $v1 / 100;
				$j = $v2 * $bs;
				$r = $v1 + $j;
				break;
			case "/":
				$r = $v1 / $v2;
				break;
			case "tj":
				$bs = $v1 / 100;
				$j = $v2 * $bs;
				$r = $j;
				break;
			default :
				$r = $v1;
				break;
		}
		$ret = @number_format($r, 2, ",", ".");
		return $ret;
	}

	public function margem_lucro($post) {
		$c = $this->Calcular(['capital' => $post['custo'], 'calculo' => "100", 'operacao' => "/"]); // valor($v1, 100, "/");
		$df = $this->Calcular(['capital' => $post['venda'], 'calculo' => $post['custo'], 'operacao' => "-"]); //valor($v2, $v1, "-");
		return $this->Calcular(['capital' => $df, 'calculo' => $c, 'operacao' => "/"]); ///($df, $c, "/");
	}

}