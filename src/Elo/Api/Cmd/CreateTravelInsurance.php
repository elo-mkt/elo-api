<?php


namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\CardData;
use Elo\Api\Cmd\VO\ProvisionedUserData;
use Elo\Api\Cmd\VO\UserData;
use Elo\Api\Crypt\EloCrypt;

class CreateTravelInsurance extends EloApiCMD
{
    /** @var ProvisionedUserData */
    private $userData;
    private $bin;
    private $politicalExposure;

    public function __construct(UserData $userData, $bin, $politicalExposure = false)
    {
        parent::__construct();
        $this->userData             = $userData;
        $this->bin                  = $bin;
        $this->politicalExposure    = $politicalExposure;
        $this->isPrivateCall        = true;
        $this->graphQLFile          = "createTravelInsurance";
    }

    public function execute()
    {
        $data = $this->userData->toArray();
        $this->call($data);
    }
}