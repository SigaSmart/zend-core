<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 23/12/2017
 * Time: 11:56
 */

namespace Admin\Form;


use Core\Form\AbstractForm;
use Zend\Filter\File\RenameUpload;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;
use Zend\Validator\File\MimeType;
use Zend\Validator\File\Size;

class UploadForm extends AbstractForm
{
	private $input;
	protected $overwrite=true;
	protected $use_upload_name=true;
	protected $use_upload_extension=true;
	protected $randomize=false;
	protected $basePath;
	protected $ds = DIRECTORY_SEPARATOR;
	protected $send;

	public function __construct($name = null, array $options = [])
	{
		parent::__construct('AjaxUploadForm', $options);

		// Set POST method for this form.
		$this->setAttribute('method', 'post');

		// Set binary content encoding.
		$this->setAttribute('enctype', 'multipart/form-data');

		$this->addElements();
	}

	// This method adds elements to form.
	protected function addElements()
	{
		// Add "file" field.
		$this->add([
			'type'  => 'file',
			'name' => 'file',
			'attributes' => [
				'id' => 'file'
			],
			'options' => [
				'label' => 'Image file',
			],
		]);

	}

	// This method creates input filter (used for form filtering/validation).
	public function addInputFilter($controller,$Id)
	{
		$inputFilter = new InputFilter();
		$this->input = new FileInput('file');
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
			'target' => $this->getBasePath($controller,$Id)
		]);
		$this->input->getFilterChain()->attach($renameUpload);
		// Add validation rules for the "file" field.
		$inputFilter->add($this->input);
		return $inputFilter;
	}

	protected function getMimiType($Types = 'ext-image-min'){
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
	public function setOverwrite(bool $overwrite): UploadForm
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
	public function setUseUploadName(bool $use_upload_name): UploadForm
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
	public function setUseUploadExtension(bool $use_upload_extension): UploadForm
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
	public function setRandomize(bool $randomize): UploadForm
	{
		$this->randomize = $randomize;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getBasePath($controller,$Id)
	{
		$this->CheckFolder($controller,$Id);
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
	public function CheckFolder($Folder,$Id) {
		list($y, $m) = explode('/', date('Y/m'));
		$this->CreateFolder("{$this->basePath}{$this->ds}dist");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}images");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}images{$this->ds}{$Folder}");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}images{$this->ds}{$Folder}{$this->ds}{$y}");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}images{$this->ds}{$Folder}{$this->ds}{$y}{$this->ds}{$m}{$this->ds}");
		$this->CreateFolder("{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}images{$this->ds}{$Folder}{$this->ds}{$y}{$this->ds}{$m}{$this->ds}{$this->ds}{$Id}");
		$this->basePath = "{$this->basePath}{$this->ds}dist{$this->ds}uploads{$this->ds}images{$this->ds}{$Folder}{$this->ds}{$y}{$this->ds}{$m}{$this->ds}{$this->ds}{$Id}";
		$this->send="{$this->ds}dist{$this->ds}uploads{$this->ds}images{$this->ds}{$Folder}{$this->ds}{$y}{$this->ds}{$m}{$this->ds}{$this->ds}{$Id}";
	}

}