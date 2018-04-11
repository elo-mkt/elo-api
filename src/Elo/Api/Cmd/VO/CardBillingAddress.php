<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 17:37
 */

namespace Elo\Api\Cmd\VO;


class CardBillingAddress
{
	public $context;
    public $country;
    public $city;
    public $state;
    public $zip;
    public $place;
    public $cardId;
    public $number;
	
	public function __construct(string $cardId = null)
	{
		$this->cardId = $cardId;
	}
    
	public function toArray()
	{
		$result = [];
		$data = (array) $this;
		
		foreach ($data as $key=>$value)
			if($value) $result[$key] = $value;
		
		return $result;
    }
}