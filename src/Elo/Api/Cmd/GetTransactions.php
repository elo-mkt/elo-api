<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:37
 */

namespace Elo\Api\Cmd;

use Elo\Api\Cmd\VO\UserData;
use Elo\Api\EloClient;
use Elo\Api\Http\EloSessionHandler;

class GetTransactions extends EloApiCMD
{

    private $statusTransactions;
    private $cardId;
    private $startTimestamp;
    private $endTimestamp;

	public function __construct($cardId, $startTimestamp, $endTimestamp, $statusTransactions)
	{
		parent::__construct();
		
		$this->isPrivateCall        = true;
        $this->cardId               = $cardId;
        $this->startTimestamp       = $startTimestamp;
        $this->endTimestamp         = $endTimestamp;
        $this->statusTransactions   = $statusTransactions;
		$this->graphQLFile          = "getTransactions";
	}

	public function execute()
	{
        $data['cardId']             = $this->cardId;
        $data['startTimestamp']     = $this->startTimestamp;
        $data['endTimestamp']       = $this->endTimestamp;
        $data['statusTransactions'] = $this->statusTransactions;
        $data['status']             = $this->statusTransactions;

		$this->call($data);
	}
}