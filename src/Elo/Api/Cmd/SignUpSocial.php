<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 16/04/18
 * Time: 11:44
 */

namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\UserData;
use Elo\Api\Http\EloSessionHandler;

class SignUpSocial extends EloApiCMD
{
	/** @var UserData */
	private $userData;
	/** @var string */
	private $provider;
	/** @var string */
	private $accessToken;
	/** @var string */
	private $expiresIn;
	
	/**
	 * SignUpSocial constructor.
	 * @param UserData $userData
	 * @param $provider
	 * @param $accessToken
	 * @param $expiresIn
	 */
	public function __construct(UserData $userData, $provider, $accessToken, $expiresIn)
	{
		parent::__construct();
		$this->userData = $userData;
		$this->provider = $provider;
		$this->accessToken = $accessToken;
		$this->expiresIn = $expiresIn;
		$this->isPrivateCall = false;
		$this->graphQLFile = "createUserSocial";
	}
	
	public function execute()
	{
		$data = $this->userData->toArray();
		$data['provider'] = $this->provider;
		$data['accessToken'] = $this->accessToken;
		if($this->expiresIn) $data['expiryTimestamp'] = $this->expiresIn;
		$this->call( $data );
		
		if($this->failed())
			return;
		
		EloSessionHandler::set([
			'userId'      => $this->getData()->createUser->id,
			'userName'    => $this->getData()->createUser->name,
			'accessToken' => $this->getData()->createUser->id,
		]);
		
		$this->createCardHolders();
	}
	
	private function createCardHolders()
	{
		$cmd = new CreateCardHolder();
		$cmd->execute();
	}
}