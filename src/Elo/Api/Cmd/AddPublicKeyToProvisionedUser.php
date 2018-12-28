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

class AddPublicKeyToProvisionedUser extends EloApiCMD
{
	/** @var UserData */
	private $userId;
    public $jwtHandler;
    private $keyId;

    public function __construct(string $keyId ,string $userId)
	{
		parent::__construct();
		$this->userId = $userId;
        $this->keyId = $keyId;
		$this->isPrivateCall = true;
		$this->graphQLFile = "addPublicKeyToProvisionedUser";
	}

	public function execute()
	{
        $jwtHandler = new JWTHandler();
        $jwtHandler->createKeys();
        $publicKey = $jwtHandler->publicKey;

        $this->jwtHandler = $jwtHandler;

        $data = [
            'key_id'       => $this->keyId,
            'key_x'        => $publicKey->get('x'),
            'key_y'        => $publicKey->get('y'),
            'userId'       => $this->userId
        ];

		$this->call($data);
	}
}