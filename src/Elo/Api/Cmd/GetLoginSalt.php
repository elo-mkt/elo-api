<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:38
 */

namespace Elo\Api\Cmd;

class GetLoginSalt extends EloApiCMD
{
	private $username;
	
	public function __construct($username)
	{
		parent::__construct();
		$this->username = str_replace(['"', "'"], '', $username);
		$this->isPrivateCall = false;
		$this->graphQLFile = "createLoginSalt";
	}
	
	public function execute()
	{
		$this->call(['username' => $this->username]);
		
		if($this->hasErrors())
			return $this->response->firstErrorMessage();
		return $this->getData()->createLoginSalt->salt;
	}
}