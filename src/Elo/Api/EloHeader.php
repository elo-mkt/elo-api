<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 18:05
 */

namespace Elo\Api;


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
		return [
			'Content-Type'  => 'application/json',
			'client_id'     => EloClient::$CLIENT_ID,
			'Authorization' => 'Basic ' . EloClient::$BASIC_AUTHORIZATION,
			'access_token'  => SessionHandler::get('accessToken'),
		];
	}
}