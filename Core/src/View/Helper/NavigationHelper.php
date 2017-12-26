<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 26/12/2017
 * Time: 14:37
 */

namespace Core\View\Helper;


use Auth\Adapter\Authentication;
use Interop\Container\ContainerInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\Navigation;

class NavigationHelper extends AbstractHelper
{
	const DEFAULT_ROLE = 'admin';
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * NavigationHelper constructor.
	 *
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * @return mixed
	 */
	public function __invoke()
	{
		// Setup ACL:
		$acl = $this->container->get('Acl\Permissions\Acl');
		/**
		 * @var  $auth Authentication
		 */
		$auth = $this->container->get(Authentication::class);
		$role = self::DEFAULT_ROLE; // The default role is guest $acl
		// With Doctrine
		if ($auth->hasIdentity()) {
			$user = $auth->getIdentity();
			$role = $user->role; // Use a view to get the name of the role
		}
		/**
		 * @var $navigation Navigation
		 */
		$navigation = $this->container->get(Navigation::class);
		// Store ACL and role in the proxy helper:
		$navigation->setAcl($acl)->setRole($role); // 'member'
		// Return the new navigation helper instance
		return $navigation;
	}
}