<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 17:21
 */

namespace Elo\Api\Cmd\VO;

class CardData
{
	public $pan;
	public $name;
	public $expiry_month;
	public $expiry_year;
	public $csc;
	public $cscEntryTime;
	public $authCode;
	public $authCodeEntryTime;
	public $holderId;
	
	/**
	 * @var CardBillingAddress
	 */
	public $billingAddress;
	
	public function __construct(string $holderId = null)
	{
//		$this->billingAddress = new CardBillingAddress();
		$this->holderId = $holderId;
	}
	
	public function cardDetailsJson()
	{
		return json_encode([
			"pan"               => $this->pan,
//			"name"              => $this->name,
			"expiry"            => [
				"month" => $this->expiry_month,
				"year"  => $this->expiry_year
			],
			"csc"               => $this->csc,
//			"cscEntryTime"      => $this->cscEntryTime,
//			"authCode"          => $this->authCode,
//			"authCodeEntryTime" => $this->authCodeEntryTime
		]);
	}
}