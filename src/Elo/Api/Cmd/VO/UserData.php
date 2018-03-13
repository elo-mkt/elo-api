<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 13/03/18
 * Time: 09:50
 */

namespace Elo\Api\Cmd\VO;


class UserData
{
	public $username;
	public $password;
	public $firstName;
	public $lastName;
	public $displayName;
	public $name;
	public $birthday;
	public $cpf;
	public $rgNumber;
	public $issuerOrganization;
	public $issuerState;
	public $issueDate;
	public $emailContext;
	public $email;
	public $addressContext;
	public $city;
	public $stateCode;
	public $state;
	public $zip;
	public $number;
	public $place;
	public $complement;
	public $phoneContext;
	public $phone;
	
	
	public function toArray()
	{
		$result = [];
		$data = (array) $this;
		
		foreach ($data as $key=>$value)
			if($value) $result[$key] = $value;
		
		return $result;
	}
}