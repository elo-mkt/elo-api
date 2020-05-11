<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 16:04
 */

namespace Elo\Api;

use Elo\Api\Cmd\AddAgreementMailMarketingToUser;
use Elo\Api\Cmd\AddAgreementToProvisionedUser;
use Elo\Api\Cmd\AddPublicKeyToProvisionedUser;
use Elo\Api\Cmd\AllBins;
use Elo\Api\Cmd\Bin;
use Elo\Api\Cmd\CreateCard;
use Elo\Api\Cmd\CreateExtendedWarrantyInsurance;
use Elo\Api\Cmd\CreateProvisionedCard;
use Elo\Api\Cmd\CreateProvisionedUser;
use Elo\Api\Cmd\CreatePurchaseProtectionInsurance;
use Elo\Api\Cmd\CreateTravelInsurance;
use Elo\Api\Cmd\DeleteCard;
use Elo\Api\Cmd\DeletePublicKey;
use Elo\Api\Cmd\DeleteUser;
use Elo\Api\Cmd\GetAllServicesByBin;
use Elo\Api\Cmd\GetCardHolders;
use Elo\Api\Cmd\GetCards;
use Elo\Api\Cmd\GetChallenge;
use Elo\Api\Cmd\GetCPF;
use Elo\Api\Cmd\GetEloPublicKey;
use Elo\Api\Cmd\GetMaskedUserContacts;
use Elo\Api\Cmd\GetProfileData;
use Elo\Api\Cmd\GetProvisionedOrigin;
use Elo\Api\Cmd\GetProvisionedUser;
use Elo\Api\Cmd\GetLoginSalt;
use Elo\Api\Cmd\GetProvisionedUserByOriginAndCPF;
use Elo\Api\Cmd\GetTransactions;
use Elo\Api\Cmd\InsuranceProductCategory;
use Elo\Api\Cmd\Login;
use Elo\Api\Cmd\LoginSocial;
use Elo\Api\Cmd\RemoveAgreementMailMarketingToUser;
use Elo\Api\Cmd\RequestPasswordRequestByEmail;
use Elo\Api\Cmd\RequestPasswordReset;
use Elo\Api\Cmd\ResetPassword;
use Elo\Api\Cmd\ResetPasswordByType;
use Elo\Api\Cmd\SignUp;
use Elo\Api\Cmd\SignUpSocial;
use Elo\Api\Cmd\StorePublicKey;
use Elo\Api\Cmd\UpdateCardBillingAddress;
use Elo\Api\Cmd\UpdateProfile;
use Elo\Api\Cmd\UpdateProvisionedUser;
use Elo\Api\Cmd\UserAgreement;
use Elo\Api\Cmd\VO\CardBillingAddress;
use Elo\Api\Cmd\VO\CardData;
use Elo\Api\Cmd\VO\PasswordResetByTypeData;
use Elo\Api\Cmd\VO\PasswordResetData;
use Elo\Api\Cmd\VO\ProvisionedUserData;
use Elo\Api\Cmd\VO\PurchaseProtectionData;
use Elo\Api\Cmd\VO\UserData;
use Elo\Api\Http\EloResponse;
use Elo\Api\Http\EloSessionHandler;
use FG\ASN1\Universal\Enumerated;

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
	
	/**
	 * Clears all previous stored response errors.
	 */
	public static function clearPreviousResponseErrors()
	{
		EloResponse::clearErrors();
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
     * @param string $userData
     * @return EloResponse
     */
    public function getProvisionedUser($usercpf)
    {
        $cmd = new GetProvisionedUser($usercpf);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param $origin
     * @return EloResponse
     */
    public function getProvisionedOriginLeads($origin)
    {
        $cmd = new GetProvisionedOrigin($origin);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param string $usercpf
     * @param string $origin
     * @return EloResponse
     */
    public function getProvisionedUserByOriginAndCPF($usercpf, $origin)
    {
        $cmd = new GetProvisionedUserByOriginAndCPF($origin, $usercpf);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param UserData $userData
     * @return EloResponse
     */
    public function createProvisionedUser(ProvisionedUserData $userData)
    {
        $cmd = new CreateProvisionedUser($userData);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param ProvisionedUserData $userData
     * @return EloResponse
     */
    public function updateProvisionedUser(ProvisionedUserData $userData)
    {
        $cmd = new UpdateProvisionedUser($userData);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param string $userId
     * @return EloResponse
     */
    public function addPublicKeyToProvisionedUser(string $keyId, string $userId)
    {
        $cmd = new AddPublicKeyToProvisionedUser($keyId, $userId);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param CardData $cardData
     * @return EloResponse
     * @throws \Exception
     */
    public function createProvisionedCard(CardData $cardData, $userId)
    {
        $cmd = new CreateProvisionedCard($cardData, $userId);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param string $bin
     * @return EloResponse
     */
    public function bin(string $bin)
    {
        $cmd = new Bin($bin);
        $cmd->execute();
        return $cmd->response;
    }

    public function allBins()
    {
        $cmd = new AllBins();
        $cmd->execute();
        return $cmd->response;
    }

    public function maskedUserContacts(string $cpf)
    {
        $cmd = new GetMaskedUserContacts($cpf);
        $cmd->execute();
        return $cmd->response;
    }

	/**
	 * @param UserData $userData
	 * @param $provider
	 * @param $accessToken
	 * @param $expiresIn
	 * @return EloResponse
	 */
	public function signUpSocial(UserData $userData, $provider, $accessToken, $expiresIn)
	{
		$cmd = new SignUpSocial($userData, $provider, $accessToken, $expiresIn);
		$cmd->execute();
		return $cmd->response;
	}
	
	/**
	 * @return EloResponse
	 */
	public function deleteAccount()
	{
		$cmd = new DeleteUser();
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
	 * @param $username
	 * @param $provider
	 * @param $accessToken
	 * @return EloResponse
	 */
	public function loginSocial($username, $provider, $accessToken)
	{
		$cmd = new LoginSocial($username, $provider, $accessToken);
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
     * @param string $cpf
     * @param string $email
     * @return EloResponse
     */
    public function requestPasswordReset(string $cpf, string $type)
    {
        $cmd = new RequestPasswordReset($cpf, $type);
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
     * @param PasswordResetByTypeData $data
     * @return EloResponse
     */
    public function resetPasswordByType(PasswordResetByTypeData $data)
    {
        $cmd = new ResetPasswordByType($data);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param CardData $cardData
     * @return EloResponse
     * @throws \Exception
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

    /**
     * @param CardBillingAddress $billingAddress
     * @return EloResponse
     */
    public function updateCardBillingAddress(CardBillingAddress $billingAddress)
	{
		$cmd = new UpdateCardBillingAddress($billingAddress);
		$cmd->execute();
		return $cmd->response;
	}

    /**
     * @param string $userId
     * @return EloResponse
     */
    public function addAgreementMailMarketingToUser(string $userId)
	{
		$cmd = new AddAgreementMailMarketingToUser($userId);
		$cmd->execute();
		return $cmd->response;
	}

    /**
     * @param string $userId
     * @return EloResponse
     */
    public function removeAgreementMailMarketingToUser(string $userId)
	{
		$cmd = new RemoveAgreementMailMarketingToUser($userId);
		$cmd->execute();
		return $cmd->response;
	}

    /**
     *
     * @return EloResponse
     */
    public function userAgreement()
	{
		$cmd = new UserAgreement();
		$cmd->execute();
		return $cmd->response;
	}

    public function getCardHolders()
    {
        $cmd = new GetCardHolders();
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param UserData $userData
     * @param string $bin
     * @param boolean $politicalExposure
     * @return EloResponse
     */
    public function createTravelInsurance($userData, $bin, $politicalExposure)
    {
        $cmd = new CreateTravelInsurance($userData, $bin, $politicalExposure);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param string $bin
     * @return EloResponse
     */
    public function createExtendedWarrantyInsurance($bin)
    {
        $cmd = new CreateExtendedWarrantyInsurance($bin);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param PurchaseProtectionData $purchaseData
     * @param string $bin
     * @return EloResponse
     */
    public function createPurchaseProtectionInsurance($purchaseData, $bin)
    {
        $cmd = new CreatePurchaseProtectionInsurance($purchaseData, $bin);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     *
     * @return EloResponse
     */
    public function listCategoriesProducts()
    {
        $cmd = new InsuranceProductCategory();
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param integer $user_id
     * @return EloResponse
     */
    public function addAgreementToProvisionedUser($user_id)
    {
        $cmd = new AddAgreementToProvisionedUser($user_id);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param string $cardId
     * @param string $startTimestamp
     * @param string $endTimestamp
     * @param Enumerated $statusTransactions
     * @return EloResponse
     */
    public function getTransactions($cardId, $startTimestamp, $endTimestamp, $statusTransactions)
    {
        $cmd = new GetTransactions($cardId, $startTimestamp, $endTimestamp, $statusTransactions);
        $cmd->execute();
        return $cmd->response;
    }

    /**
     * @param string $bin
     * @return EloResponse
     */
    public function getAllServicesByBin(string $bin)
    {
        $cmd = new GetAllServicesByBin($bin);
        $cmd->execute();
        return $cmd->response;
    }
}