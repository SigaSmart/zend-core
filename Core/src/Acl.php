<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 26/12/2017
 * Time: 15:03
 */

namespace Core;

use Interop\Container\ContainerInterface;
use Zend\Permissions\Acl\Acl as ZendAcl,
	Zend\Permissions\Acl\Role\GenericRole as Role,
	Zend\Permissions\Acl\Resource\GenericResource as Resource;
class Acl extends ZendAcl
{

	/**
	 * @var array
	 */
	private $roles;
	/**
	 * @var array
	 */
	private $privileges;
	/**
	 * @var ContainerInterface
	 */
	private $container;
	private $my_resources;
	private $is_admin;
	private $all_roles;

	/**
	 * Acl constructor.
	 *
	 * @param array $resources
	 * @param array $roles
	 * @param array $privileges
	 */
	public function __construct(ContainerInterface $container,array $resources, array $roles, array $privileges)
	{
		$this->container = $container;
		$this->my_resources = array_merge($this->getConfigResources('factories'),
			$this->getConfigResources('invokables'));
		$this->roles = $roles;
		$this->privileges = $privileges;
		$this->setRoles()
			->setResource()
			->setPrivileges();

	}

	protected function setRoles(){

		foreach ($this->roles as $role) {
			//Verifica a role ja foi add
			if (!$this->hasRole((string) $role['id'])) {
				//Inicia os parents da role ex:1 e parent da 2 a 2 da 3 etc
				//a 1 herda da 2,3,4 e 5
				$parentNames = array();
				if (!is_null($role['parent']) && (int) $role['parent']) {
					$parentNames = (string) $role['parent'];
				}
				//Adiciana a role
				$this->addRole(new Role((string) $role['id']), $parentNames);
			}
			//Se a role for admin conceda totos os privileges
			if ($role['is_admin']) {
				$this->is_admin = $role['id'];
			}
			$this->all_roles[]=$role['id'];
		}
		return $this;
	}

	public function setResource()
	{
		foreach ($this->my_resources as $key =>$resource) {
			if (!$this->hasResource($key)) {
				$this->addResource(new Resource($key));
			}
		}
		return $this;
	}

	public function setPrivileges()
	{
		foreach ($this->privileges as $privilege) {
			$allprivileges = array_merge(explode(",", $privilege['action']),explode(",", $privilege['parent']));
			$this->allow($privilege['role'], $privilege['controller'], $allprivileges);
		}
		$this->allow($this->all_roles, ['Admin\Controller\Admin','Auth\Controller\Auth','Home\Controller\Home'], null);

		if($this->is_admin):
			$this->allow($this->is_admin, null, null);
		endif;
		return $this;
	}
	protected function getConfigResources($string)
	{
		if(!isset($this->container->get('Config')['controllers'][$string])):
			return [];
		endif;
		return $this->container->get('Config')['controllers'][$string];

	}

}