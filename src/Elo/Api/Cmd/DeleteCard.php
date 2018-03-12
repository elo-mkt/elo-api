<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 19:34
 */

namespace Elo\Api\Cmd;


class DeleteCard extends EloApiCMD
{
	private $cardId;
	
	public function __construct($cardId)
	{
		parent::__construct();
		$this->cardId = $cardId;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'deleteCard';
	}
	
	public function execute()
	{
		$this->call(['cardId' => $this->cardId]);
	}
}