<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 17:18
 */

namespace Elo\Api\Cmd;


use Elo\Api\Cmd\VO\CardData;
use Elo\Api\Crypt\JWTHandler;
use Elo\Api\SchemaHandler;

class CreateCard extends EloApiCMD
{
	/** @var CardData */
	private $cardData;
	
	/** @var  JWTHandler */
	private $jwtHandler;
	
	public function __construct(CardData $cardData)
	{
		parent::__construct();
		$this->cardData = $cardData;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'createCard';
	}
	
	public function execute()
	{
		$keyId = bin2hex(random_bytes(10));
		$storeResponse = $this->createAndStorePublicKey( $keyId );
		if($storeResponse->hasErrors())
			throw new \Exception($storeResponse->firstErrorMessage());
		
		$data = [
			"encryptedCard"  => $this->jwtHandler->createSensitiveToken( $this->cardData->cardDetailsJson() ),
			"holderId"       => $this->cardData->holderId,
			"addressContext" => $this->cardData->billingAddress->context,
			"country"        => $this->cardData->billingAddress->country,
			"city"           => $this->cardData->billingAddress->city,
			"state"          => $this->cardData->billingAddress->state,
			"zip"            => $this->cardData->billingAddress->zip,
			"place"          => $this->cardData->billingAddress->place,
			"number"         => $this->cardData->billingAddress->number,
		];
		
//		SchemaHandler::$debugQuery = true;
		
		$this->call($data);
		
		$this->deletePublicKey($keyId);
	}
	
	private function createAndStorePublicKey(string $keyId)
	{
		$cmd = new StorePublicKey($keyId);
		$cmd->execute();
		$this->jwtHandler = $cmd->jwtHandler;
		
		return $cmd->response;
	}
	
	private function deletePublicKey(string $keyId)
	{
		$cmd = new DeletePublicKey($keyId);
		$cmd->execute();
	}
}