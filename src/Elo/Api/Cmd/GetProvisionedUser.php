<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 10/03/18
 * Time: 17:52
 */

namespace Elo\Api\Cmd;

use Elo\Api\Cmd\VO\ProvisionedUserData;
use Elo\Api\Cmd\VO\UserData;

class GetProvisionedUser extends EloApiCMD
{
	/** @var UserData  */
	private $usercpf;

	public function __construct($usercpf)
	{
		parent::__construct();
		$this->usercpf = $usercpf;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'getProvisionedUser';
	}

	public function execute()
	{
        $data = [
            'cpf'       => $this->usercpf
        ];

		$this->call($data);
	}
}
