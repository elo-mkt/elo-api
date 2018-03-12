<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 19:01
 */

namespace Elo\Api\Cmd;

use Elo\Api\Crypt\JWTHandler;
use Elo\Api\Http\EloSessionHandler;

class StorePublicKey extends EloApiCMD
{
	/** @var JWTHandler */
	public $jwtHandler;
	
	private $keyId;
	
	public function __construct(string $keyId)
	{
		parent::__construct();
		$this->keyId = $keyId;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'storePublicKey';
	}
	
	public function execute()
	{
		$jwtHandler = new JWTHandler();
		$jwtHandler->createKeys();
		$publicKey = $jwtHandler->publicKey;
		
		$this->jwtHandler = $jwtHandler;
		
		$data = [
			'key_id'       => $this->keyId,
			'key_x'        => $publicKey->get('x'),
			'key_y'        => $publicKey->get('y'),
			'access_token' => EloSessionHandler::get('accessToken'),
		];
		
		$this->call($data);
	}
}
