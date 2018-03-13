<?php

namespace Elo\Api\Cmd;

use Elo\Api\Cmd\VO\UserData;
use Elo\Api\Crypt\EloCrypt;
use Elo\Api\Http\EloSessionHandler;

/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:26
 */

class SignUp extends EloApiCMD
{
	/** @var UserData */
	private $userData;
	
	public function __construct(UserData $userData)
	{
		parent::__construct();
		$this->userData = $userData;
		$this->isPrivateCall = false;
		$this->graphQLFile = "createUser";
	}
	
	public function execute()
	{
		$eloCrypt = new EloCrypt();
		
		$data = $this->userData->toArray();
		$data['password'] = $eloCrypt->bcryptUserPassword($this->userData->username, $this->userData->password);
		$this->call( $data );
		
		if($this->failed())
			return;
		
		EloSessionHandler::set([
			'userId'      => $this->getData()->createUser->id,
			'userName'    => $this->getData()->createUser->name,
			'accessToken' => $this->getData()->createUser->id,
		]);
		
		$this->createCardHolders();
		
		return null;
	}
	
	private function createCardHolders()
	{
		$cmd = new CreateCardHolder();
		$cmd->execute();
	}
}