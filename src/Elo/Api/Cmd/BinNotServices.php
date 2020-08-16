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

class BinNotServices extends EloApiCMD
{
	/** @var UserData */
	private $bin;

    public function __construct(string $bin)
	{
		parent::__construct();
		$this->bin = $bin;
		$this->isPrivateCall = true;
		$this->graphQLFile = "binNotServices";
	}

	public function execute()
	{
	    $data = [
            'bin'       => $this->bin
        ];

		$this->call($data);
	}
}