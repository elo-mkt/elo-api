<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 15:45
 */

namespace Elo\Api\Cmd\VO;

use Elo\Api\Crypt\EloCrypt;

class PasswordResetByTypeData
{
	
	public $password;
	public $cpf;
	public $username;
	public $type;
	public $token;

	private function getEncryptedPassword()
	{
		$eloCrypt = new EloCrypt();
		return $eloCrypt->bcryptUserPassword($this->username, $this->password);
	}
	
	public function toArray()
	{
		$clone = (array) $this;
		$clone['password'] = $this->getEncryptedPassword();
		return $clone;
	}
}