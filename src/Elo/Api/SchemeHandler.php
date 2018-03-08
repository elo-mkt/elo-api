<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 17:47
 */

namespace Elo\Api;


class SchemeHandler
{
	public static function getScheme($graphQLName, $data = [])
	{
		$graphQL = file_get_contents( __DIR__ . "/graphql/$graphQLName.graphql", FILE_USE_INCLUDE_PATH);
		
		$keys = ["\n", "\t"];
		$values = ["", ""];
		
		foreach($data as $key => $value)
		{
			$keys[] = $key;
			$values[] = $value;
		}
		
		$graphQL = str_replace($keys, $values, $graphQL);
		
		return $graphQL;
	}
}