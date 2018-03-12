<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 15:45
 */

namespace Elo\Api\Cmd\VO;

use Elo\Api\Crypt\EloCrypt;

class PasswordResetData
{
	
	public $password;
	public $cpf;
	public $username;
	public $email;
	public $phone;
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