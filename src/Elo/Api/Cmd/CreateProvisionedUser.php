<?php

namespace Elo\Api\Cmd;

use Elo\Api\Cmd\VO\ProvisionedUserData;
use Elo\Api\Crypt\EloCrypt;
use Elo\Api\Http\EloSessionHandler;

/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:26
 */

class CreateProvisionedUser extends EloApiCMD
{
	/** @var ProvisionedUserData */
	private $userData;

	public function __construct(ProvisionedUserData $userData)
	{
		parent::__construct();
		$this->userData = $userData;
		$this->isPrivateCall = false;
		$this->graphQLFile = "createProvisionedUser";
	}
	
	public function execute()
	{
		$eloCrypt = new EloCrypt();

		$data = $this->userData->toArray();
		$data['password'] = $eloCrypt->bcryptUserPassword($this->userData->username, $this->userData->password);
		$this->call( $data );

		if($this->failed())
			return;
		
		return null;
	}
}