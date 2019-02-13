<?php

namespace Elo\Api\Cmd;

use Elo\Api\Cmd\VO\UserData;
use Elo\Api\Crypt\EloCrypt;
use Elo\Api\Crypt\JWTHandler;
use Elo\Api\Http\EloSessionHandler;

/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:26\
 */

class AllBins extends EloApiCMD
{

    public function __construct()
	{
		parent::__construct();
		$this->isPrivateCall = true;
		$this->graphQLFile = "allBins";
	}

	public function execute()
	{
		$this->call();
	}
}