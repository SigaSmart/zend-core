<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Auth\Adapter;

use Zend\Authentication\Storage\Session as SessionStorage;
class AuthStorage extends SessionStorage
{
	/**
	 * @param int $rememberMe
	 * @param int $time
	 */
	public function setRememberMe($rememberMe = 0, $time = 32096000) {
		if ($rememberMe == 1) {
			$this->session->getManager()->rememberMe($time);
		}
	}
	/**
	 *
	 */
	public function forgetMe() {
		$this->session->getManager()->forgetMe();
	}

	/**
	 * @return O Id Da Sessão
	 */
	public function getSessionId()
	{
		return $this->session->getManager()->getId();
	}
}