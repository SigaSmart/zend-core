<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */


namespace Core;

use Auth\Adapter\Authentication;
use Core\View\Helper\AclHelper;
use Core\View\Helper\RouteHelper;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Service\ViewHelperManagerFactory;

abstract class AbstractCommon
{


	public function __construct(ContainerInterface $container)
	{
		$this->ViewHelperManager=$container->get('ViewHelperManager');
		$this->container = $container;
		$this->url = $this->ViewHelperManager->get('url');
		$this->basePath = $this->ViewHelperManager->get('basePath');
		$this->acl = $this->ViewHelperManager->get('Acl');
		$this->Route = $this->ViewHelperManager->get('Route');
	}

	/**
	 * @var ContainerInterface
	 */
	protected $container;
	/**
	 * @var object
	 */
	protected $user;

	/**
	 * @var $acl AclHelper
	 */
	protected $acl;

	/**
	 * @var $Route RouteHelper
	 */
	protected $Route;

	/**
	 * @var $ViewHelperManager ViewHelperManagerFactory
	 */
	protected $ViewHelperManager;

	/**
	 * helper para geração de rotas
	 * @var $url
	 */
	protected $url;

	/**
	 * A pasta public do sistema
	 * @var $basePath
	 */
	protected $basePath;

    /**
     * Table object
     * @var AbstractTable
     */
    protected $table;

	/**
	 * @return Acl
	 */
	public function getAcl(): Acl
	{
		return $this->acl;
	}

	/**
	 * @param Acl $acl
	 *
	 * @return AbstractCommon
	 */
	public function setAcl(Acl $acl): AbstractCommon
	{
		$this->acl = $acl;
		return $this;
	}

	/**
	 * @return RouteHelper
	 */
	public function getRoute(): RouteHelper
	{
		return $this->Route;
	}

	/**
	 * @param RouteHelper $Route
	 *
	 * @return AbstractCommon
	 */
	public function setRoute(RouteHelper $Route): AbstractCommon
	{
		$this->Route = $Route;
		return $this;
	}

	/**
	 * @return object
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param $user
	 *
	 * @return AbstractCommon
	 */
	public function setUser($user): AbstractCommon
	{
		$this->user = $user;
		return $this;
	}



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
	public function getUrl($Route, $params = [],$query = [])
	{
		$Url = $this->url;
		return $Url($Route, $params,$query);
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
