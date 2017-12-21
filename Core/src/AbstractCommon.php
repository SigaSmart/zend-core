<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */


namespace Core;

use Interop\Container\ContainerInterface;

abstract class AbstractCommon
{


	public function __construct(ContainerInterface $container)
	{
		$this->ViewHelperManager=$container->get('ViewHelperManager');
		$this->container = $container;
		$this->url = $this->ViewHelperManager->get('url');
		$this->basePath = $this->ViewHelperManager->get('basePath');
	}

	/**
	 * @var ContainerInterface
	 */
	protected $container;

	protected $ViewHelperManager;

	protected $url;

	protected $basePath;

    /**
     * Table object
     * @var AbstractTable
     */
    protected $table;

    /**
     *
     * @return AbstractTable
     */
    public function getTable()
    {
        return $this->table;
    }


    /**
     *
     * @param AbstractTable $table
     * @return \Core\AbstractCommon
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getViewHelperManager()
	{
		return $this->ViewHelperManager;
	}

	/**
	 * @return mixed
	 */
	public function getUrl($Route, $params = [])
	{
		$Url = $this->url;
		return $Url($Route, $params);
	}

	/**
	 * @return mixed
	 */
	public function getBasePath($Path="")
	{
		$basePath = $this->basePath;
		return $basePath($Path);
	}


}
