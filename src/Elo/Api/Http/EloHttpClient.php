<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 18:51
 */

namespace Elo\Api\Http;


use Elo\Api\EloClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class EloHttpClient
{
	public static function publicCall($body, $method = 'POST')
	{
		$httpClient = new Client();
		
		$requestData = [
			'headers' => EloHeader::publicHeader(),
			'body'    => $body
		];
		
		try
		{
			$clientResponse = $httpClient->request($method, EloClient::$PUBLIC_URL, $requestData);
			$response = json_decode($clientResponse->getBody());
		}
		catch (ClientException $e)
		{
			if($e->hasResponse()) $response = json_decode($e->getResponse()->getBody());
			else throw $e;
		}
		
		return EloResponse::create($response, $requestData);
	}
	
	public static function privateCall($body, $method = 'POST')
	{
		$httpClient = new Client();
		$requestData = [
			'headers' => EloHeader::privateHeader(),
			'body'    => $body
		];
		
		try
		{
			$clientResponse = $httpClient->request($method, EloClient::$PRIVATE_URL, $requestData);
			$response = json_decode($clientResponse->getBody());
		}
		catch (ClientException $e)
		{
			if($e->hasResponse()) $response = json_decode($e->getResponse()->getBody());
			else throw $e;
		}
		
		return EloResponse::create($response, $requestData);
	}
}