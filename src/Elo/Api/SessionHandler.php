<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 18:37
 */

namespace Elo\Api;


class SessionHandler
{
	public static function set($values)
	{
		@session_start();
		foreach ($values as $key=>$value)
			$_SESSION["elo-api::".$key] = $value;
	}
	
	public static function get($key)
	{
		@session_start();
		return $_SESSION["elo-api::".$key];
	}
	
	public static function destroy()
	{
		@session_start();
		session_unset();
		session_destroy();
	}
}