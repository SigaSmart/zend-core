<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 15/12/2017
 * Time: 19:09
 */

namespace Auth\Adapter;

use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as Adapter;
use Zend\Db\Adapter\AdapterInterface;

class Authentication
{


	protected $authenticate;
	protected $result;
	const SUCCESS = 1;
	const FAILURE = 0;
	const FAILURE_IDENTITY_NOT_FOUND = -1;
	const FAILURE_IDENTITY_AMBIGUOUS = -2;
	const FAILURE_CREDENTIAL_INVALID = -3;
	const FAILURE_UNCATEGORIZED = -4;

	public function __construct(AdapterInterface $adapter)
	{
		// The status field value of an account is not equal to "compromised"
		$this->authenticate = new Adapter(
			$adapter,
			'users',
			'email',
			'password'
			//'MD5(?) AND status != "1"'
		);
	}

	public function login(string $login, string $password){
		// Set the input credential values (e.g., from a login form):
		$this->authenticate->setIdentity($login)
			->setCredential($password);
		// Perform the authentication query, saving the result
		$this->result = $this->authenticate->authenticate();
		return $this->result;
	}
	public function getResult()
	{

		switch ($this->result->getCode()) {

			case self::FAILURE_IDENTITY_NOT_FOUND:
				/** do stuff for nonexistent identity **/
				return "do stuff for nonexistent identity";
				break;

			case self::FAILURE_CREDENTIAL_INVALID:
				/** do stuff for invalid credential **/
				return "do stuff for invalid credential";
				break;

			case self::SUCCESS:
				/** do stuff for successful authentication **/
				return "do stuff for successful authentication";
				break;

			default:
				/** do stuff for other failure **/
				return "do stuff for other failure";
				break;
		}
	}
}