<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 18:09
 */

namespace Elo\Api\Cmd;


use Elo\Api\EloClient;
use Elo\Api\Http\EloHeader;
use Elo\Api\Http\EloResponse;

class GetEloPublicKey extends EloApiCMD
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function execute()
	{
		$res = $this->httpClient->request('GET', EloClient::$PUBLIC_KEY_URL, [
			'headers' => EloHeader::publicHeader()
		]);
		
		$this->response = EloResponse::create((object)["data" =>json_decode($res->getBody()) ]);
	}
}