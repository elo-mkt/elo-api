<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:37
 */

namespace Elo\Api\Cmd;

use Elo\Api\Cmd\VO\UserData;

class GetProfileData extends EloApiCMD
{
	public function __construct()
	{
		parent::__construct();
		
		$this->isPrivateCall = true;
		$this->graphQLFile = "profileData";
	}
	
	public function execute()
	{
		$this->call();
		
		if($this->failed())
			return null;
		
		$this->getData()->userData = UserData::profileDataToUserData($this->getData()->user);
		
		return $this->getData()->user;
	}
}