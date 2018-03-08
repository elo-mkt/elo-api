<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 16:04
 */

namespace Elo\Api;

use Elo\Api\Crypt\EloCrypt;
use GuzzleHttp\Client;

class EloClient
{
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
		self::$CLIENT_ID            = $settings['CLIENT_ID'];
		self::$BASIC_AUTHORIZATION  = $settings['BASIC_AUTHORIZATION'];
		self::$PUBLIC_URL           = $settings['PUBLIC_URL'];
		self::$PRIVATE_URL          = $settings['PRIVATE_URL'];
		self::$PUBLIC_KEY_URL       = $settings['PUBLIC_KEY_URL'];
	}
	
	
	public function __construct()
	{
		self::init([
			"CLIENT_ID"           => "dcebc3db-22ef-388b-b4d6-f0637751c622",
			"BASIC_AUTHORIZATION" => "ZGNlYmMzZGItMjJlZi0zODhiLWI0ZDYtZjA2Mzc3NTFjNjIyOmQzYzhlOWNlLTE3NjctM2EzZS05NjBjLTg2ZjkxY2I3NDBkZg==",
			"PUBLIC_URL"          => "https://hml-api.elo.com.br/graphql",
			"PRIVATE_URL"         => "https://hml-api.elo.com.br/graphql-private",
			"PUBLIC_KEY_URL"      => "https://hml-api.elo.com.br/user/v1/publickeys",
		]);
		
		$this->httpClient    = new Client();
	}
	
	
	public function getProfileData()
	{
		$body = SchemeHandler::getScheme('profileData');
		$res = $this->httpClient->request('POST', self::$PRIVATE_URL, [
			'headers' => EloHeader::privateHeader(),
			'body'    => $body
		]);
		
		$result = json_decode($res->getBody());
		$user = $result->data->user;
		
		return $user;
	}
	
	
	public function login($username, $password)
	{
		$this->checkVars();
		
		$eloCrypt = new EloCrypt();
		$encryptedPassword = $eloCrypt->bcryptUserPassword($username, $password);
		$apiSalt = $this->getSaltLogin($username);
		$challenge = $eloCrypt->bcryptChallengePasswordSync($encryptedPassword, $apiSalt);
		
		$body = SchemeHandler::getScheme('login', ['$username' => $username, '$challenge'=>$challenge]);
		
		$res = EloHttp::publicCall($body);
		
		$result = json_decode($res->getBody());
		
		if(property_exists($result, 'errors') && $result->errors)
			return $result->errors[0]->message;
		
		if(property_exists($result, 'data') && property_exists($result->data, 'login'))
		{
			SessionHandler::set([
				'accessToken'      => $result->data->login->accessToken,
				'clientMutationId' => $result->data->login->clientMutationId
			]);
		}
		
		$userProfile = $this->getProfileData();
		if (property_exists($userProfile->legalIds, 'cpf')) {
			SessionHandler::set(['cpf' => $userProfile->legalIds->cpf->number]);
		}
		
		return 'logged in '.SessionHandler::get('accessToken');
	}
	
	private function getSaltLogin($username)
	{
		$username = str_replace(['"', "'"], '', $username);
		$body = SchemeHandler::getScheme('createLoginSalt', ['$username' => $username]);
		
		$res = $this->httpClient->request('POST', self::$PUBLIC_URL, [
			'headers' => EloHeader::publicHeader(),
			'body'    => $body
		]);
		
		return json_decode($res->getBody())->data->createLoginSalt->salt;
	}
	
	private function checkVars()
	{
		if( !self::$CLIENT_ID || !self::$BASIC_AUTHORIZATION || !self::$PUBLIC_URL || !self::$PRIVATE_URL || !self::$PUBLIC_KEY_URL)
			throw new \Exception('Please initialize firstly Elo\\Api\\EloClient::init($settings).');
	}
}