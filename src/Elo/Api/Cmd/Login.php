<?php

namespace Elo\Api\Cmd;

use Elo\Api\Crypt\EloCrypt;
use Elo\Api\SchemaHandler;
use Elo\Api\Http\EloSessionHandler;

/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:26
 */

class Login extends EloApiCMD
{
	private $username;
	private $password;
	
	public function __construct($username, $password)
	{
		parent::__construct();
		$this->username = $username;
		$this->password = $password;
		
		$this->isPrivateCall = false;
		$this->graphQLFile = "login";
	}
	
	public function execute()
	{
		$this->call([
			'username' => $this->username,
			'challenge'=> $this->createChallenge()
		]);
		
		if($this->failed())
			return $this->response->firstErrorMessage();
		
		$responseData = $this->response->getData();
		
		if($responseData && property_exists($responseData, 'login'))
		{
			EloSessionHandler::set([
				'accessToken'      => $responseData->login->accessToken,
				'clientMutationId' => $responseData->login->clientMutationId
			]);
		}
		
		$this->loadDataIntoSession();
		
		$this->checkCardHolders();
	}
	
	private function loadDataIntoSession()
	{
		$cmd = new GetCPF();
		$cmd->execute();
	}
	
	private function checkCardHolders()
	{
		$cmd = new GetProfileData();
		$userProfile = $cmd->execute();
		if(!$userProfile->cardHolders || count($userProfile->cardHolders) < 1)
		{
			$cmd = new CreateCardHolder();
			$cmd->execute();
		}
	}
	
	private function createChallenge()
	{
		$eloCrypt = new EloCrypt();
		$encryptedPassword = $eloCrypt->bcryptUserPassword($this->username, $this->password);
		$apiSalt = $this->getSaltLogin($this->username);
		return $eloCrypt->bcryptChallengePasswordSync($encryptedPassword, $apiSalt);
	}
	
	private function getSaltLogin($username)
	{
		$getSalt = new GetLoginSalt($username);
		return $getSalt->execute();
	}
}