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

class GetProvisionedUserByOriginAndCPF extends EloApiCMD
{
	/** @var UserData  */
	private $origin;
	private $cpf;

	public function __construct($origin, $cpf)
	{
		parent::__construct();
		$this->origin = $origin;
		$this->cpf = $cpf;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'getProvisionedUserByOriginAndCPF';
	}

	public function execute()
	{
        $data = [
            'origin' => $this->origin,
            'cpf'   => $this->cpf
        ];

		$this->call($data);
	}
}
