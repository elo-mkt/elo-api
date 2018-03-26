<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 16:04
 */

namespace Elo\Api;

use Elo\Api\Cmd\CreateCard;
use Elo\Api\Cmd\DeleteCard;
use Elo\Api\Cmd\DeletePublicKey;
use Elo\Api\Cmd\GetCards;
use Elo\Api\Cmd\GetChallenge;
use Elo\Api\Cmd\GetCPF;
use Elo\Api\Cmd\GetEloPublicKey;
use Elo\Api\Cmd\GetProfileData;
use Elo\Api\Cmd\GetLoginSalt;
use Elo\Api\Cmd\Login;
use Elo\Api\Cmd\RequestPasswordRequestByEmail;
use Elo\Api\Cmd\ResetPassword;
use Elo\Api\Cmd\SignUp;
use Elo\Api\Cmd\StorePublicKey;
use Elo\Api\Cmd\UpdateCardBillingAddress;
use Elo\Api\Cmd\UpdateProfile;
use Elo\Api\Cmd\VO\CardBillingAddress;
use Elo\Api\Cmd\VO\CardData;
use Elo\Api\Cmd\VO\PasswordResetData;
use Elo\Api\Cmd\VO\UserData;
use Elo\Api\Http\EloResponse;
use Elo\Api\Http\EloSessionHandler;

class EloClient
{
	static $USE_SESSION         =false;
	static $CLIENT_ID           =null;
	static $BASIC_AUTHORIZATION =null;
	static $PUBLIC_URL          =null;
	static $PRIVATE_URL         =null;
	static $PUBLIC_KEY_URL      =null;
	
	/**
	 * @param $settings array Array with the following variables:  
	 * <pre>
	 * CLIENT_ID:           The client id
	 * BASIC_AUTHORIZATION: The token which authorizes the application to make api calls
	 * PUBLIC_URL:          The public GraphQL url.
	 * PRIVATE_URL:         The private GraphQL url.
	 * PUBLIC_KEY_URL:      The url which returns the public key for encryption.
	 * </pre>
	 */
	public static function init($settings)
	{
		self::$USE_SESSION          = strtolower($settings['ELO_USE_SESSION']) == 'true';
		self::$CLIENT_ID            = $settings['ELO_CLIENT_ID'];
		self::$BASIC_AUTHORIZATION  = $settings['ELO_BASIC_AUTHORIZATION'];
		self::$PUBLIC_URL           = $settings['ELO_PUBLIC_URL'];
		self::$PRIVATE_URL          = $settings['ELO_PRIVATE_URL'];
		self::$PUBLIC_KEY_URL       = $settings['ELO_PUBLIC_KEY_URL'];
	}
	
	
	public static function setAccessCredentials(string $cpf, string $accessToken)
	{
		EloSessionHandler::set([
			"cpf" => $cpf,
			"accessToken" => $accessToken,
		]);
	}
	
	public function __construct($settings = null)
	{
		if($settings) self::init($settings);
	}
	
	
	
	
	
	
	
	
	
	/**
	 * @param $username
	 * @return EloResponse
	 */
	public function getLoginSalt($username)
	{
		$cmd = new GetLoginSalt($username);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @param $username
	 * @param $password
	 * @return EloResponse
	 */
	public function getChallenge($username, $password)
	{
		$cmd = new GetChallenge($username, $password);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @param UserData $userData
	 * @return EloResponse
	 */
	public function signUp(UserData $userData)
	{
		$cmd = new SignUp($userData);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @param $username
	 * @param $password
	 * @return EloResponse
	 */
	public function login($username, $password)
	{
		$cmd = new Login($username, $password);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * 
	 */
	public function logout()
	{
		EloSessionHandler::destroy();
	}
	
	/**
	 * @return bool
	 */
	public function isLogged()
	{
		return !is_null(EloSessionHandler::get('accessToken'));
	}
	
	/**
	 * @return EloResponse
	 */
	public function getProfile()
	{
		$cmd = new GetProfileData();
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @return string
	 * @throws \Exception
	 */
	public function getCPF()
	{
		$cmd = new GetCPF();
		$cmd->execute();
		return ($cmd->response->getData());
	}
	
	/**
	 * @param $keyId
	 * @return EloResponse
	 */
	public function storePublicKey($keyId)
	{
		$cmd = new StorePublicKey($keyId);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @param $keyId
	 * @return EloResponse
	 */
	public function deletePublicKey($keyId)
	{
		$cmd = new DeletePublicKey($keyId);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @return EloResponse
	 */
	public function getEloPublicKey()
	{
		$cmd = new GetEloPublicKey();
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @param UserData $userData
	 * @return EloResponse
	 */
	public function updateProfile(UserData $userData)
	{
		$cmd = new UpdateProfile($userData);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @param string $cpf
	 * @param string $email
	 * @return EloResponse
	 */
	public function requestPasswordResetByEmail(string $cpf, string $email)
	{
		$cmd = new RequestPasswordRequestByEmail($cpf, $email);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @param PasswordResetData $data
	 * @return EloResponse
	 */
	public function resetPassword(PasswordResetData $data)
	{
		$cmd = new ResetPassword($data);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @param CardData $cardData
	 * @return EloResponse
	 */
	public function createCard(CardData $cardData)
	{
		$cmd = new CreateCard($cardData);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @param string $cardId
	 * @return EloResponse
	 */
	public function deleteCard(string $cardId)
	{
		$cmd = new DeleteCard($cardId);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @return EloResponse
	 */
	public function getCards()
	{
		$cmd = new GetCards();
		$cmd->execute();
		return $cmd->response;
	}
	
	public function updateCardBillingAddress(CardBillingAddress $billingAddress)
	{
		$cmd = new UpdateCardBillingAddress($billingAddress);
		$cmd->execute();
		return $cmd->response;
	}
}