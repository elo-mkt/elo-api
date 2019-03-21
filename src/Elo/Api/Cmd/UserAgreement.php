<?php

namespace Elo\Api\Cmd;

use Elo\Api\Cmd\VO\UserData;
use Elo\Api\Crypt\EloCrypt;
use Elo\Api\Crypt\JWTHandler;
use Elo\Api\Http\EloSessionHandler;

/**
 * Created by PhpStorm.
 * User: ezequielgomes
 * Date: 2019-03-20
 * Time: 09:34
 */

class UserAgreement extends EloApiCMD
{

    public function __construct()
	{
		parent::__construct();
        $this->isPrivateCall = true;
		$this->graphQLFile = "userAgreement";
	}

	public function execute()
	{

        $data = [

        ];

		$this->call($data);
	}
}