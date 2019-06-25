<?php


namespace Elo\Api\Cmd\VO;


class PurchaseProtectionData
{
    public $invoiceNumber;
    public $invoiceDate;
    public $brand;
    public $model;
    public $value;
    public $description;
    public $productId;

    public function toArray()
    {
        $result = [];
        $data = (array) $this;

        foreach ($data as $key=>$value)
            if($value) $result[$key] = $value;

        return $result;
    }
}