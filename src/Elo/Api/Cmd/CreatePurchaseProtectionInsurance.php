<?php


namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\PurchaseProtectionData;
use Elo\Api\Cmd\VO\UserData;

class CreatePurchaseProtectionInsurance extends EloApiCMD
{
    public $purchaseData;
    public $bin;

    public function __construct(PurchaseProtectionData $purchaseData, $bin)
    {
        parent::__construct();
        $this->purchaseData = $purchaseData;
        $this->bin = $bin;
        $this->isPrivateCall = true;
        $this->graphQLFile = "createPurchaseProtectionInsurance";
    }

    public function execute()
    {
        $data = $this->purchaseData->toArray();
        $data['bin'] = $this->bin;

        $this->call($data);
    }
}