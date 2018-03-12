<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 07/03/18
 * Time: 11:30
 */

namespace Elo\Api\Crypt;


use Elo\Api\EloClient;
use Jose\Component\Core\JWK;
use Jose\Component\KeyManagement\JWKFactory;

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\Converter\StandardConverter;
use Jose\Component\Encryption\Algorithm\ContentEncryption\A128CBCHS256;
use Jose\Component\Encryption\Algorithm\KeyEncryption\ECDHES;
use Jose\Component\Encryption\Compression\CompressionMethodManager;
use Jose\Component\Encryption\JWEBuilder;

use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

class JWTHandler
{
	/**
	 * @var JWK
	 */
	public $privateKey;
	/**
	 * @var JWK
	 */
	public $publicKey;
	
	public function createSensitiveToken(string $jsonPayload)
	{
		$this->checkKeys();
		
		$payload = $this->signPayload($jsonPayload);
		return $this->encryptPayload($payload);
	}
	
	public function signPayload(string $payload)
	{
		$this->checkKeys();
		
		$jsonConverter = new StandardConverter();
		
		$algManager = AlgorithmManager::create([
			new ES256(),
		]);
		
		$jwsBuilder2 = new JWSBuilder(
			$jsonConverter,
			$algManager
		);
		
		$jws2 = $jwsBuilder2
			->create()                               
			->withPayload($payload)                  
			->addSignature($this->privateKey, ['alg' => 'ES256'])
			->build();                               
		
		$serializer = new CompactSerializer($jsonConverter);
		return $serializer->serialize($jws2, 0);
	}
	
	public function encryptPayload(string $payload)
	{
		$this->checkKeys();
		
		// The key encryption algorithm manager with the A256KW algorithm.
		$keyEncryptionAlgorithmManager = AlgorithmManager::create([
			new ECDHES(),
		]);
		
		// The content encryption algorithm manager with the A256CBC-HS256 algorithm.
		$contentEncryptionAlgorithmManager = AlgorithmManager::create([
			new A128CBCHS256(),
		]);
		
		// The compression method manager with the DEF (Deflate) method.
		$compressionMethodManager = CompressionMethodManager::create([]);
		
		// The JSON Converter.
		$jsonConverter = new StandardConverter();
		
		// We instantiate our JWE Builder.
		$jweBuilder = new JWEBuilder(
			$jsonConverter,
			$keyEncryptionAlgorithmManager,
			$contentEncryptionAlgorithmManager,
			$compressionMethodManager
		);
		
		$jwk = $this->getEloPublicKey();
		
		$jwe = $jweBuilder
			->create()
			->withPayload($payload)
			->withSharedProtectedHeader([
				'alg' => 'ECDH-ES',       // Key Encryption Algorithm
				'enc' => 'A128CBC-HS256', // Content Encryption Algorithm
			])
			->addRecipient($jwk)  
			->build();
		
		$serializer = new \Jose\Component\Encryption\Serializer\CompactSerializer($jsonConverter);
		$token = $serializer->serialize($jwe, 0);
		
		return $token;
	}
	
	private function getEloPublicKey()
	{
		$eloClient = new EloClient();
		$response = $eloClient->getEloPublicKey();
		
		if(!$response->isSuccess())
			throw new \Exception($response->firstErrorMessage());
		
		$eloPublicKey = $response->getData();
		$jwk = JWK::create([
			"kty" => $eloPublicKey->kty,
			"crv" => $eloPublicKey->crv,
			"x" => $eloPublicKey->x,
			"y" => $eloPublicKey->y
		]);
		return $jwk;
	}
	
	public function createKeys(object $privateKey = null)
	{
		if(is_null($privateKey))
		{
			$this->privateKey = JWKFactory::createECKey('P-256');
		}
		else
		{
			$pk = $privateKey;
			$this->privateKey = JWK::create([
				"kty" => $pk->kty,
				"crv" => $pk->crv,
				"d" => $pk->d,
				"x" => $pk->x,
				"y" => $pk->y
			]);
		}
		
		$this->publicKey = $this->privateKey->toPublic();
	}
	
	private function checkKeys()
	{
//		if(is_null($this->privateKey) || is_null($this->publicKey))
//			throw new \Exception('Please, create firstly the private and public keys.');
	}
}