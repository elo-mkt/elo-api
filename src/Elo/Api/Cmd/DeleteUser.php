<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 15/04/18
 * Time: 13:42
 */

namespace Elo\Api\Cmd;


use Elo\Api\Http\EloSessionHandler;

class DeleteUser extends EloApiCMD
{
	public function __construct()
	{
		parent::__construct();
		$this->isPrivateCall = true;
		$this->graphQLFile = "deleteUser";
	}
	
	public function execute()
	{
		$this->call([
			'userId' => EloSessionHandler::get('accessToken')
		]);
	}
}