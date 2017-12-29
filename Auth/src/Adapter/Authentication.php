<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Auth\Adapter;

use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\ClassMethods;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Session\Storage\StorageInterface;
use Zend\Stdlib\ArrayObject;

class Authentication
{


	protected $authenticate;
	protected $result;
	protected $type = FlashMessenger::NAMESPACE_ERROR;
	const SUCCESS = 1;
	const FAILURE = 0;
	const FAILURE_IDENTITY_NOT_FOUND = -1;
	const FAILURE_IDENTITY_AMBIGUOUS = -2;
	const FAILURE_CREDENTIAL_INVALID = -3;
	const FAILURE_UNCATEGORIZED = -4;

	/**
	 * Authentication constructor.
	 *
	 * @param AuthenticationService $authenticate
	 */
	public function __construct(AuthenticationService $authenticate)
	{
		// The status field value of an account is not equal to "compromised"
		$this->authenticate = $authenticate;
	}

	public function login(string $login, string $password){
		// Set the input credential values (e.g., from a login form):
		$this->getAdapter()->setIdentity($login)
			->setCredential($password);
		// Perform the authentication query, saving the result
		$this->result = $this->getAdapter()->authenticate();
		if($this->result->isValid()):
			$user = $this->getAdapter()->getResultRowObject(null,['password','user_active','password_salt']);
			$this->getStorage()->write($user);
		endif;
		return $this->result;
	}

	/**
	 * Returns the authentication adapter
	 *
	 * The adapter does not have a default if the storage adapter has not been set.
	 *
	 * @return AdapterInterface|null
	 */
	public function getAdapter()
	{
		return $this->authenticate->getAdapter();
	}

	/**
	 * Returns the persistent storage handler
	 *
	 * Session storage is used by default unless a different storage adapter has been set.
	 *
	 * @return StorageInterface
	 */
	public function getStorage()
	{
		return $this->authenticate->getStorage();
	}

	/**
	 * Returns true if and only if an identity is available from storage
	 *
	 * @return bool
	 */
	public function hasIdentity()
	{
		return $this->authenticate->hasIdentity();
	}

	/**
	 * Returns the identity from storage or null if no identity is available
	 *
	 * @return mixed|null
	 */
	public function getIdentity()
	{
		return $this->authenticate->getIdentity();
	}

	/**
	 * Clears the identity from persistent storage
	 *
	 * @return void
	 */
	public function clearIdentity()
	{
		$this->getStorage()->clear();
		$this->authenticate->clearIdentity();
	}


	public function getResult()
	{
		switch ($this->result->getCode()) {

			case self::FAILURE_IDENTITY_NOT_FOUND:
				$this->type = FlashMessenger::NAMESPACE_WARNING;
				/** do stuff for nonexistent identity **/
				return "do stuff for nonexistent identity";
				break;

			case self::FAILURE_CREDENTIAL_INVALID:
				$this->type = FlashMessenger::NAMESPACE_INFO;
				/** do stuff for invalid credential **/
				return "do stuff for invalid credential";
				break;

			case self::SUCCESS:
				$this->type = FlashMessenger::NAMESPACE_SUCCESS;
				/** do stuff for successful authentication **/
				return "do stuff for successful authentication";
				break;

			default:
				$this->type = FlashMessenger::NAMESPACE_ERROR;
				/** do stuff for other failure **/
				return "do stuff for other failure";
				break;
		}
	}

	public function getType()
	{
		return $this->type;
	}
	public function toArray(){

		$hidrator = new ArrayObject();
		$hidrator->exchangeArray($this->getIdentity());
		return $hidrator->getArrayCopy();
	}

}