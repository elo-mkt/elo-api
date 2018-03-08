<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 18:51
 */

namespace Elo\Api;


use GuzzleHttp\Client;

class EloHttp
{
	public static function publicCall($body, $method = 'POST')
	{
		$httpClient = new Client();
		
		$response = $httpClient->request('POST', EloClient::$PUBLIC_URL, [
			'headers' => EloHeader::publicHeader(),
			'body'    => $body
		]);
		
		return $response;
	}
}