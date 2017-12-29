<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/12/2017
 * Time: 00:48
 */

namespace Core\Factory;


use Admin\Table\PrivilegeTable;
use Admin\Table\ResourceTable;
use Admin\Table\RoleTable;
use Core\Acl;
use Core\View\Helper\AclHelper;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AclFactory implements FactoryInterface
{

	/**
	 * Create an object
	 *
	 * @param  ContainerInterface $container
	 * @param  string             $requestedName
	 * @param  null|array         $options
	 *
	 * @return object
	 */
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$Resources = $container->get(ResourceTable::class)->select(['status'=>1]);
		/**
		 * @var $RolesTable RoleTable
		 */
		$RolesTable = $container->get(RoleTable::class);
		$Roles = $RolesTable->getSelect(['status'=>1]);
		$Roles->order(['id'=>'DESC']);
		$RolesTable->setStmt($RolesTable->getSql()->prepareStatementForSqlObject($Roles));
		$RolesTable->exec();
		$PrivilegesTable = $container->get(PrivilegeTable::class);
		$Privileges= $PrivilegesTable->getSelect(['status'=>1]);
		$Privileges->join( ['b' => 'roles'],        // join table with alias
			'privileges.role = b.id',  // join expression
			['is_admin']);
		$Privileges->order(['role'=>'ASC']);
		$PrivilegesTable->setStmt($PrivilegesTable->getSql()->prepareStatementForSqlObject($Privileges));
		$PrivilegesTable->exec();
		$acl = new Acl($container,$Resources, $RolesTable->getResultSet()->toArray(), $PrivilegesTable->getResultSet()->toArray());
		return new AclHelper($acl);
	}
}