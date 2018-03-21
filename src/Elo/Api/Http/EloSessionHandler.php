<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 18:37
 */

namespace Elo\Api\Http;


use Elo\Api\EloClient;

class EloSessionHandler
{
	private static $vars;
	
	private static function init()
	{
		$sessionName = '09a654cd41013c92ab86';
		@session_name( $sessionName );
		@session_start();
	}
	
	public static function set($values)
	{
		if(EloClient::$USE_SESSION)
		{
			self::init();
			foreach ($values as $key=>$value)
				$_SESSION["elo-api::".$key] = $value;
		}
		else
		{
			foreach ($values as $key=>$value)
				self::$vars[$key] = $value;
		}
	}
	
	public static function get($key)
	{
		if(EloClient::$USE_SESSION)
		{
			self::init();
			return @$_SESSION["elo-api::".$key];
		}
		
		return @self::$vars[$key];
	}
	
	public static function destroy()
	{
		self::$vars = [];
		
		if(EloClient::$USE_SESSION)
		{
			self::init();
			session_unset();
			session_destroy();
		}
	}
}