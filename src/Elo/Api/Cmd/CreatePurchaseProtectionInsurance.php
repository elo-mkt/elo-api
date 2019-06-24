<?php


namespace Elo\Api\Cmd;


class CreatePurchaseProtectionInsurance extends EloApiCMD
{
    public function __construct()
    {
        parent::__construct();
//        $this->userData = $userData;
        $this->isPrivateCall = true;
        $this->graphQLFile = "createPurchaseProtectionInsurance";
    }

    public function execute()
    {
        $this->call();
    }
}