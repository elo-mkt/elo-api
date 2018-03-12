<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 18:37
 */

namespace Elo\Api\Http;


class EloSessionHandler
{
	private static function init()
	{
		$sessionName = '09a654cd41013c92ab86';
		@session_name( $sessionName );
		@session_start();
	}
	
	public static function set($values)
	{
		self::init();
		foreach ($values as $key=>$value)
			$_SESSION["elo-api::".$key] = $value;
	}
	
	public static function get($key)
	{
		self::init();
		return @$_SESSION["elo-api::".$key];
	}
	
	public static function destroy()
	{
		self::init();
		session_unset();
		session_destroy();
	}
}