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
	public $agreements;
	public $cpf;
	public $rgNumber;
	public $issuerOrganization;
	public $issuerState;
	public $issueDate;
	public $emailContext;
	public $email;
	public $origin;
    public $country;
	public $addressContext;
	public $city;
	public $stateCode;
	public $state;
	public $district;
	public $zip;
	public $number;
	public $place;
	public $complement;
	public $phoneContext;
	public $phone;
	public $socialAccessToken;
	public $gender;
	public $maritalStatus;
	public $ticket;
	public $event;
	public $currency;
	public $value;
	public $dateTime;

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
			$userData = new UserData();
			$userData->username = $profileData->username;
			$userData->firstName = $profileData->firstName;
			$userData->lastName = $profileData->lastName;
			$userData->name = $profileData->name;
			$userData->gender = $profileData->gender;
			$userData->origin = $profileData->origin;
			$userData->birthday = $profileData->birthday;
			$userData->agreements = $profileData->agreements;

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

	public static function parseContacts(UserData &$userData, $profileData)
	{
		if($profileData->contacts)
		{
			foreach ($profileData->contacts as $contact)
			{
				if(strtolower($contact->type) == "email")
				{
					$userData->email = $contact->value;
					$userData->emailContext = $contact->context;
				}
				else if(strtolower($contact->type) == "phone")
				{
					$userData->phone = $contact->value;
					$userData->phoneContext = $contact->context;
				}
			}
		}
	}

	public static function parseAddresses(UserData &$userData, $profileData)
	{
		if($profileData->addresses)
		{
			foreach ($profileData->addresses as $address)
			{
//				if(strtolower($address->context) == "casa")
//				{
					$userData->addressContext = $address->context;
					$userData->country = $address->country;
					$userData->state = $address->state;
					$userData->district = $address->district;
					$userData->city = $address->city;
					$userData->zip = $address->zip;
					$userData->number = $address->number;
					$userData->place = $address->place;
					$userData->complement = $address->complement;
//				}
			}
		}
	}

	public static function parseLegalIds(UserData &$userData, $profileData)
	{
		/** @var UserData $userData */
		if($profileData->legalIds)
		{
			$legalIds = $profileData->legalIds;
			if($legalIds->cpf)
				$userData->cpf = $legalIds->cpf->number;

			if($legalIds->rg)
			{
				$userData->rgNumber = $legalIds->rg->number;
				$userData->issueDate = $legalIds->rg->issueDate;
				$userData->issuerState = $legalIds->rg->issuerState;
				$userData->issuerOrganization = $legalIds->rg->issuerOrganization;
			}
		}
	}
}
