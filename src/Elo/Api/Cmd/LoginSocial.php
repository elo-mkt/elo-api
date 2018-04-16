<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 16/04/18
 * Time: 11:27
 */

namespace Elo\Api\Cmd;


use Elo\Api\EloClient;
use Elo\Api\Http\EloSessionHandler;

class LoginSocial extends EloApiCMD
{
	private $username;
	private $provider;
	private $accessToken;
	
	public function __construct($username, $provider, $accessToken)
	{
		parent::__construct();
		
		$this->username = $username;
		$this->provider = $provider;
		$this->accessToken = $accessToken;
		
		$this->isPrivateCall = false;
		$this->graphQLFile = "loginSocial";
	}
	
	public function execute()
	{
		$this->call([
			'username'    => $this->username,
			'provider'    => $this->provider,
			'accessToken' => $this->accessToken,
		]);
		
		if($this->failed())
			return $this->response->firstErrorMessage();
		
		$responseData = $this->response->getData();
		
		if($responseData && property_exists($responseData, 'socialNetworkOAuthLogin'))
			$this->loadDataIntoSession($responseData->socialNetworkOAuthLogin->accessToken);
		
		$this->checkCardHolders();
	}
	
	private function loadDataIntoSession($accessToken)
	{
		// command getCPF needs the accessToken stored in session.
		EloSessionHandler::set(['accessToken' => $accessToken]);
		
		//
		$cmd = new GetCPF();
		$cmd->execute();
		$cpf = $cmd->response->getData();
		
		//
		EloClient::setAccessCredentials($cpf, $accessToken);
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
}