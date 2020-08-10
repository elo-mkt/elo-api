<?php


namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\UserData;

class AddGranularAgreementToProvisionedUser extends EloApiCMD
{
    /** @var UserData */
    private $userId;
    private $receiveEmail;
    private $receiveSms;

    public function __construct(string $userId, $receiveEmail = false, $receiveSms = false)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->receiveEmail = $receiveEmail;
        $this->receiveSms = $receiveSms;

        $this->isPrivateCall = true;
        $this->graphQLFile = null;
    }

    public function execute()
    {
        if($this->receiveSms and $this->receiveEmail){
            $this->graphQLFile = "addGranularAgreementEmailAndSmsToProvisionedUser";
        }else{
            if($this->receiveSms){
                $this->graphQLFile = "addGranularAgreementSmsToProvisionedUser";
            }else if($this->receiveEmail){
                $this->graphQLFile = "addGranularAgreementEmailToProvisionedUser";
            }
        }


        $data = [
            'userId'    => $this->userId,
        ];

        $this->call($data);
    }
}