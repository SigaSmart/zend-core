<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 31/12/2017
 * Time: 16:10
 */

namespace Core\Service;


use Interop\Container\ContainerInterface;
use Zend\Filter\File\RenameUpload;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\AbstractOptions;
use Zend\Validator\File\MimeType;
use Zend\Validator\File\Size;

class ImagesFilter  extends AbstractOptions
{
	const FILE = 'file';
	const CODE_SUCCESS = 'success';
	const CODE_ERROR = 'error';
	protected $input;
	protected $overwrite=true;
	protected $use_upload_name=true;
	protected $use_upload_extension=true;
	protected $randomize=false;
	protected $basePath;
	protected $ds = "/";
	protected $send;
	/**
	 * @var ContainerInterface
	 */
	protected $container;
	protected $realFolder;
	protected $result;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	// This method creates input filter (used for form filtering/validation).
	public function addInputFilter($Type,$controller,$Id)
	{
		$inputFilter = new InputFilter();
		$this->input = new FileInput(self::FILE);
		$this->input->getValidatorChain()->attach(new Size(
				[
					'max' => "5000MB",
					'messageTemplates' => [
						Size::TOO_BIG => 'O arquivo fornecido é maior que o tamanho de arquivo permitido',
						Size::TOO_SMALL => 'O arquivo fornecido é muito pequeno',
						Size::NOT_FOUND => 'O arquivo não pode ser encontrado']
				]
			)
		);
		$mimetype = new MimeType();
		$mimetype->setMessages(array(
			MimeType::FALSE_TYPE => 'Este arquivo não é um tipo permitido',
			MimeType::NOT_DETECTED => 'O tipo de arquivo não foi detectado',
			MimeType::NOT_READABLE => 'O tipo de arquivo não era legível',
		));
		$mimetype->setMimeType($this->getMimiType());
		$this->input->getValidatorChain()->attach($mimetype);
		$renameUpload = new RenameUpload([
			'overwrite' => $this->isOverwrite(),
			'use_upload_name' => $this->isUseUploadName(),
			'use_upload_extension' => $this->isUseUploadExtension(),
			'randomize'=>$this->isRandomize(),
			'target' => $this->getBasePath($Type,$controller,$Id)
		]);
		$this->input->getFilterChain()->attach($renameUpload);
		// Add validation rules for the "file" field.
		$inputFilter->add($this->input);
		return $inputFilter;
	}

	protected function getMimiType($Types = 'ext-image-thumb'){
		$MimiType=[];
		$Config = $this->container->get("Config");
		$mime_types_custom =$Config['mime_types_custom'];
		$mime_types = $Config['mime_types'];
		if(isset($mime_types_custom[$Types])):
			foreach ($mime_types_custom[$Types] as $type):
				$MimiType[] = $mime_types[$type];
			endforeach;
		endif;
		return $MimiType;
	}

	/**
	 * @return bool
	 */
	public function isOverwrite(): bool
	{
		return $this->overwrite;
	}

	/**
	 * @param bool $overwrite
	 *
	 * @return UploadForm
	 */
	public function setOverwrite(bool $overwrite)
	{
		$this->overwrite = $overwrite;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isUseUploadName(): bool
	{
		return $this->use_upload_name;
	}

	/**
	 * @param bool $use_upload_name
	 *
	 * @return UploadForm
	 */
	public function setUseUploadName(bool $use_upload_name)
	{
		$this->use_upload_name = $use_upload_name;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isUseUploadExtension(): bool
	{
		return $this->use_upload_extension;
	}

	/**
	 * @param bool $use_upload_extension
	 *
	 * @return UploadForm
	 */
	public function setUseUploadExtension(bool $use_upload_extension)
	{
		$this->use_upload_extension = $use_upload_extension;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isRandomize(): bool
	{
		return $this->randomize;
	}

	/**
	 * @param bool $randomize
	 *
	 * @return UploadForm
	 */
	public function setRandomize(bool $randomize)
	{
		$this->randomize = $randomize;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getBasePath($Type,$controller,$Id)
	{
		$this->CheckFolder($Type,$controller,$Id);
		return $this->basePath;
	}

	/**
	 * @param mixed $basePath
	 *
	 * @return UploadForm
	 */
	public function setBasePath($basePath)
	{
		$this->basePath = $basePath;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSend()
	{
		return $this->send;
	}

	//Verifica e cria os diretórios com base em tipo de arquivo, ano e mês!
	public function CheckFolder($Type,$Folder,$Id) {
		list($y, $m) = explode('/', date('Y/m'));
		$this->CreateFolder("{$this->basePath}{$this->ds}dist");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}{$Type}");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}{$Type}{$this->ds}{$Folder}");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}{$Type}{$this->ds}{$Folder}{$this->ds}{$y}");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}{$Type}{$this->ds}{$Folder}{$this->ds}{$y}{$this->ds}{$m}{$this->ds}");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}{$Type}{$this->ds}{$Folder}{$this->ds}{$y}{$this->ds}{$m}{$this->ds}{$Id}{$this->ds}");
		$this->basePath = "{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}{$Type}{$this->ds}{$Folder}{$this->ds}{$y}{$this->ds}{$m}{$this->ds}{$Id}{$this->ds}";
		$this->send="{$this->ds}dist{$this->ds}uploads{$this->ds}{$Type}{$this->ds}{$Folder}{$this->ds}{$y}{$this->ds}{$m}{$this->ds}{$Id}{$this->ds}";
	}

	//Verifica e cria o diretório base!
	public function CreateFolder($Folder) {
		if (!file_exists($Folder) && !is_dir($Folder)):
			mkdir($Folder, 0777);
		endif;
	}

	//Verifica e monta o nome dos arquivos tratando a string!
	public function setFileName($Name) {
		$FileName = $this->setName(substr($Name, 0, strrpos($Name, '.')));
		return sprintf("%s%s%s",date("YmdHis") ,strtolower($FileName), strrchr($Name, '.'));
	}

	/**
	 * <b>Tranforma URL:</b> Retira acentos e caracteres especias!
	 * @param STRING $Name = Uma string qualquer
	 * @return STRING um nome tratado
	 */
	public function setName($Name) {
		$var = strtolower(utf8_encode($Name));
		return preg_replace('{\W}', '', preg_replace('{ +}', '_', strtr(
			utf8_decode(html_entity_decode($var)), utf8_decode('ÀÁÃÂÉÊÍÓÕÔÚÜÇÑàáãâéêíóõôúüçñ'), 'AAAAEEIOOOUUCNaaaaeeiooouucn')));
	}

}