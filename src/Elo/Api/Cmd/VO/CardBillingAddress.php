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
	
	public function __construct(string $cardId = null)
	{
		$this->cardId = $cardId;
	}
    
	public function toArray()
	{
		return (array) $this;
    }
}