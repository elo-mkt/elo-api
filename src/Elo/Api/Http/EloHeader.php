<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 18:05
 */

namespace Elo\Api\Http;


use Elo\Api\EloClient;

class EloHeader
{
	public static function publicHeader()
	{
		return [
			'Content-Type'  => 'application/json',
			'client_id'     => EloClient::$CLIENT_ID,
			'Authorization' => 'Basic ' . EloClient::$BASIC_AUTHORIZATION,
		];
	}
	
	public static function privateHeader()
	{
		$accessToken = EloSessionHandler::get('accessToken');
		$headers = [
			'Content-Type'  => 'application/json',
			'client_id'     => EloClient::$CLIENT_ID,
			'Authorization' => 'Basic ' . EloClient::$BASIC_AUTHORIZATION,
		];
		if($accessToken) $headers['access_token']  = $accessToken;
		return $headers;
	}
}