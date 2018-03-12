<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 12:32
 */

namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\PasswordResetData;

class ResetPassword extends EloApiCMD
{
	private $data;
	
	public function __construct(PasswordResetData $data)
	{
		parent::__construct();
		$this->data = $data;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'resetPassword';
	}
	
	public function execute()
	{
		$this->call($this->data->toArray());
	}
}