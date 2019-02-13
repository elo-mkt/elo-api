<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 13/03/18
 * Time: 09:50
 */

namespace Elo\Api\Cmd\VO;


class ProvisionedUserData extends UserData
{
	public $userId;
	public $origin;
	public $gender;

	public function toArray()
	{
		$result = [];
		$data = (array) $this;
		
		foreach ($data as $key=>$value)
			if($value) $result[$key] = $value;
		
		return $result;
	}
	
	public static function profileDataToUserData($profileData)
	{
		try
		{
			$userData = new ProvisionedUserData();
			$userData->name = $profileData->name;
			$userData->userId = $profileData->userId;
			$userData->origin = $profileData->origin;
			$userData->gender = $profileData->gender;
			$userData->birthday = $profileData->birthday;
			
			self::parseContacts($userData, $profileData);
			self::parseAddresses($userData, $profileData);
			self::parseLegalIds($userData, $profileData);
			
			return $userData;
		}
		catch(\Exception $e)
		{
			return null;
		}
	}
}