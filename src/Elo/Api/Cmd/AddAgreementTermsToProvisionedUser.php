<?php


namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\UserData;

class AddAgreementTermsToProvisionedUser extends EloApiCMD
{
    /** @var UserData */
    private $userId;
    private $termId;

    public function __construct(string $userId, string $termId)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->termId = $termId;
        $this->isPrivateCall = true;
        $this->graphQLFile = "addAgreementTermsToProvisonedUser";
    }

    public function execute()
    {
        $data = [
            'userId'    => $this->userId,
            'termId'    => $this->termId
        ];

        $this->call($data);
    }
}