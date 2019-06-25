<?php


namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\UserData;

class AddAgreementToProvisionedUser extends EloApiCMD
{
    /** @var UserData */
    private $userId;

    public function __construct(string $userId)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->isPrivateCall = true;
        $this->graphQLFile = "addAgreementToProvisionedUser";
    }

    public function execute()
    {
        $data = [
            'userId'    => $this->userId,
        ];

        $this->call($data);
    }
}