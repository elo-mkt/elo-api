<?php


namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\ProvisionedUserData;
use Elo\Api\Cmd\VO\UserData;

class CreateExtendedWarrantyInsurance extends EloApiCMD
{
    private $bin;

    public function __construct($bin)
    {
        parent::__construct();
        $this->bin                  = $bin;
        $this->isPrivateCall        = true;
        $this->graphQLFile          = "createExtendedWarrantyInsurance";
    }

    public function execute()
    {
        $data = [
            'bin'   => $this->bin
        ];

        $this->call($data);
    }
}