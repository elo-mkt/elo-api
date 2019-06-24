<?php


namespace Elo\Api\Cmd;


class InsuranceProductCategory extends EloApiCMD
{
    public function __construct()
    {
        parent::__construct();
        $this->isPrivateCall = false;
        $this->graphQLFile = "insuranceProductCategory";
    }

    public function execute()
    {
        $this->call();
    }
}