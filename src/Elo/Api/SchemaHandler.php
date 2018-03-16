<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 17:47
 */

namespace Elo\Api;


class SchemaHandler
{
	private $parents;
	private $insertedParents;
	private $keyParents;
	private $dir;
	
	public static function getSchema($graphQLName, $data = [])
	{
		$schemeHandler = new SchemaHandler();
		return $schemeHandler->createSchema($graphQLName, $data);
	}
	
	public function __construct()
	{
		$this->dir = __DIR__ . "/graphql";
		$this->parents = [];
		$this->keyParents = [];
		$this->insertedParents = [];
	}
	
	private function createSchema($graphQLName, $data)
	{
		$graphQL = file_get_contents( $this->dir . "/$graphQLName.graphql", FILE_USE_INCLUDE_PATH);
		$this->findParents($graphQL);
		
		$keys   = ["\n", "\t"];
		$values = ["", ""];
//		$keys   = [];
//		$values = [];
		
		
		foreach($data as $key => $value)
		{
			$graphQL = $this->insertParents($graphQL, $key);
			
			$varFile = $this->dir."/vars/$key.var";
			
			if (strpos($graphQL, "%$key%") !== false && file_exists($varFile))
			{
				$varContent = file_get_contents($varFile, FILE_USE_INCLUDE_PATH);
				$varContent = str_replace('$'.$key, $value, $varContent);
				
				$keys[] = "%$key%";
				$values[] = " $varContent ";
			}
			else
			{
				$keys[] = '$'.$key;
				$values[] = $value;
			}
		}
		
		$graphQL = str_replace($keys, $values, $graphQL);
		$graphQL = preg_replace('/%(\w+)(:+\w+)*%/i', " ", $graphQL);
		
//		echo $graphQL; exit;
		
		return $graphQL;
	}
	
	private function insertParents($graphQL, $key)
	{
		if( array_key_exists($key, $this->keyParents) )
		{
			$parents = $this->keyParents[$key];
			$graphQLKey = join(':', $parents).":$key";
			$hasInsertedFirstParent = false;
			
			foreach ($parents as $parent)
			{
				if( in_array($parent, $this->insertedParents) )
				{
					$hasInsertedFirstParent = true;
					continue;
				}
				
				$parentFile = $this->dir."/vars/object_"."$parent.var";
				$parentContent = file_get_contents($parentFile, FILE_USE_INCLUDE_PATH);
				
				$mainKey = '%'.(!$hasInsertedFirstParent ? $graphQLKey : $parent)."%";
				$graphQL = str_replace($mainKey, " $parentContent ", $graphQL);
				
				$this->insertedParents[] = $parent;
				$hasInsertedFirstParent = true;
			}
		}
		
		return $graphQL;
	}
	
	private function findParents($graphQL)
	{
		preg_match_all("/%(.+:)\w+%/i", $graphQL, $matches, PREG_SET_ORDER);
		foreach ($matches as $match) {
			$key = substr($match[0], 1, -1);
			$parents = explode(":", $key);
			$key = array_pop($parents);
			$this->keyParents[$key] = ($parents);
			$this->parents = array_merge($this->parents, $parents);
		}
		$this->parents = array_unique($this->parents);
	}
}