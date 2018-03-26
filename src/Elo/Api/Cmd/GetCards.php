<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 26/03/18
 * Time: 11:52
 */

namespace Elo\Api\Cmd;


class GetCards extends EloApiCMD
{
	public function __construct()
	{
		parent::__construct();
		$this->isPrivateCall = true;
		$this->graphQLFile = 'getCards';
	}
	
	public function execute()
	{
		$this->call();
	}
}