<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 16:15
 */

namespace Elo\Api\Cmd;


use Elo\Api\Crypt\EloCrypt;
use Elo\Api\Http\EloResponse;

class GetChallenge extends EloApiCMD
{
	private $username;
	private $password;
	
	public function __construct($username, $password)
	{
		parent::__construct();
		$this->username = $username;
		$this->password = $password;
	}
	
	public function execute()
	{
		$eloCrypt = new EloCrypt();
		$encryptedPassword = $eloCrypt->bcryptUserPassword($this->username, $this->password);
		$apiSalt = $this->getSaltLogin($this->username);
		$this->response = EloResponse::create((object)['data' => $eloCrypt->bcryptChallengePasswordSync($encryptedPassword, $apiSalt)]);
	}
	
	private function getSaltLogin($username)
	{
		$getSalt = new GetLoginSalt($username);
		return $getSalt->execute();
	}
}