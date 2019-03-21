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

class RemoveAgreementMailMarketingToUser extends EloApiCMD
{
	/** @var UserData */
	private $userId;

    public function __construct(string $userId)
	{
		parent::__construct();
		$this->userId = $userId;
        $this->isPrivateCall = true;
		$this->graphQLFile = "removeAgreementMailMarketingToUser";
	}

	public function execute()
	{

        $data = [
            'userId'                => $this->userId,
        ];

		$this->call($data);
	}
}