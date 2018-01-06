<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/12/2017
 * Time: 21:13
 */

namespace Core\Form;

use Auth\Adapter\Authentication;
use Core\Table\AbstractTable;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Select;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class AbstractForm extends Form
{
	/**
	 * @var ContainerInterface
	 */
	protected $container;
	protected $ValueOptionsData = [];
	private $Tables;
	protected $users;

	public function __construct($name = null, array $options = [])
	{
		parent::__construct($name, $options);

		if(isset($options['container'])):
			$this->container = $options['container'];
		endif;

		//######################## id #######################
		$this->add([
			'type'=>Hidden::class,
			'name' => 'id',
			"attributes"=>[
				'id'=>"id"
			]

		]);


		//######################## empresa #######################
		$this->add([
			'type'=>Hidden::class,
			'name' => 'empresa',
			"attributes"=>[
				'id'=>"empresa"
			]

		]);

		//######################## created_at #######################
		$this->add([
			'type'=>Text::class,
			'name' => 'created_at',
			'options'=>[
				'label'=>"Criado em:"
			],
			"attributes"=>[
				'id'=>"created_at",
				'class'=>'form-control validate date',
				'placeholder'=>"00/00/0000",
				'readonly'=>true,
				'value' => date("d/m/Y")
			]

		]);


		//######################## updated_at #######################
		$this->add([
			'type'=>Text::class,
			'name' => 'updated_at',
			'options'=>[
				'label'=>"Atualizado em:"
			],
			"attributes"=>[
				'id'=>"updated_at",
				'class'=>'form-control validate datetime',
				'placeholder'=>"00/00/0000 00:00",
				'readonly'=>true,
				'value' => date("d/m/Y H:i")
			]

		]);

       //######################## submit #######################
		$this->add([
			'type'=>Submit::class,
			'name' => 'submit',
			"attributes"=>[
				'id'=>"button",
				'class'=>'btn btn-primary btn-block btn-flat btn-block',
				'value'=>"Atualizar Cadastro"
			]
		]);

	}

	public function dbValueOptions($table, $condition=[], $collumns = ['id','name']){
		/**
		 * @var $this->Tables AbstractTable
		 */
		$this->Tables = $this->container->get($table);
		/**
		 * @var $Select Select
		 */
		$Select = $this->Tables->getSelect($condition, null,$collumns);

		return $Select;
	}

	public function getValueDb(Select $Select)
	{
		$Options=[];
		$this->Tables->setStmt($this->Tables->getSql()->prepareStatementForSqlObject($Select));

		$this->Tables->exec();

		if($this->Tables->getResultSet()->count()):
			$this->ValueOptionsData = $this->Tables->getResultSet()->toArray();
		endif;

		if($this->ValueOptionsData):
			foreach ($this->ValueOptionsData as $optionsDatum):
				$Options[reset($optionsDatum)] = end($optionsDatum);
			endforeach;
		endif;
		return $Options;
	}

	//Verifica e cria o diretório base!
	public function CreateFolder($Folder) {
		if (!file_exists($Folder) && !is_dir($Folder)):
			mkdir($Folder, 0777);
		endif;
	}

	//Verifica e monta o nome dos arquivos tratando a string!
	public function setFileName($Name) {
		$FileName = $this->setSlug(substr($Name, 0, strrpos($Name, '.')));
		return sprintf("%s%s%s",date("YmdHis") ,strtolower($FileName), strrchr($Name, '.'));
	}

	/**
	 * <b>Tranforma URL:</b> Retira acentos e caracteres especias!
	 * @param STRING $Name = Uma string qualquer
	 * @return STRING um nome tratado
	 */
	public function setSlug($Name) {
		if(!is_string($Name))return;
		$var = strtolower(utf8_encode($Name));
		return preg_replace('{\W}', '', preg_replace('{ +}', '_', strtr(
			utf8_decode(html_entity_decode($var)), utf8_decode('ÀÁÃÂÉÊÍÓÕÔÚÜÇÑàáãâéêíóõôúüçñ'), 'AAAAEEIOOOUUCNaaaaeeiooouucn')));
	}

	protected function getResources($string)
	{
		$resources=[];
		if(!isset($this->container->get('Config')['controllers'][$string])):
			return [];
		endif;
		$Result = $this->container->get('Config')['controllers'][$string];
		if($Result):
			foreach ($Result as $key => $value) {
				$resources[$key]=$key;
			}
		endif;

		return $resources;

	}

	protected function user(){
		if($this->container):
			$this->users = $this->container->get(Authentication::class)->getIdentity();
		endif;
		return $this;
	}
}