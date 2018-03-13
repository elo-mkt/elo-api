<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 10/03/18
 * Time: 17:52
 */

namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\UserData;

class UpdateProfile extends EloApiCMD
{
	/** @var UserData  */
	private $userData;
	
	public function __construct(UserData $userData)
	{
		parent::__construct();
		$this->userData = $userData;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'updateProfile';
	}
	
	public function execute()
	{
		$this->call($this->userData->toArray());
	}
}