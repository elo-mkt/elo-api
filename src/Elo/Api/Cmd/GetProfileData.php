<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:37
 */

namespace Elo\Api\Cmd;

use Elo\Api\Cmd\VO\UserData;
use Elo\Api\EloClient;
use Elo\Api\Http\EloSessionHandler;

class GetProfileData extends EloApiCMD
{
	public function __construct()
	{
		parent::__construct();
		
		$this->isPrivateCall = true;
		$this->graphQLFile = "profileData";
	}
	
	/**
	 * @return null
	 * @throws \Exception
	 */
	public function execute()
	{
		$this->call();
		
		if($this->failed())
			return null;
		
		$userData = null;
		if(!$this->response->hasErrors() || ($this->response->hasData() && $this->getData()->user))
			$userData = UserData::profileDataToUserData($this->getData()->user);

		if($userData)
			$this->getData()->userData = UserData::profileDataToUserData($this->getData()->user);
		else 
		{
			EloSessionHandler::destroy();
			throw new \Exception("INVALID TOKEN");
		}
		
		return $this->getData()->user;
	}
}