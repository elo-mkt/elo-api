<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 19:55
 */

namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\CardBillingAddress;

class UpdateCardBillingAddress extends EloApiCMD
{
	
	private $billingAddress;
	
	public function __construct(CardBillingAddress $billingAddress)
	{
		parent::__construct();
		$this->billingAddress = $billingAddress;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'updateCard';
	}
	
	public function execute()
	{
		$this->call($this->billingAddress->toArray());
	}
}