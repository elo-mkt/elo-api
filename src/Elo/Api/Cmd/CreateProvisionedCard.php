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

class CreateProvisionedCard extends EloApiCMD
{
	/** @var CardData */
	private $cardData;

	/** @var  JWTHandler */
	private $jwtHandler;

	private $userId;

	public function __construct(CardData $cardData, string $userId)
	{
		parent::__construct();
		$this->cardData = $cardData;
		$this->userId = $userId;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'createProvisionedCard';
	}

	public function execute()
	{
		$keyId = bin2hex(random_bytes(10));
		$storeResponse = $this->createAndStorePublicKey( $keyId, $this->userId );
		if($storeResponse->hasErrors())
			throw new \Exception($storeResponse->firstErrorMessage());
		$data = [
			"encryptedCard"  => $this->jwtHandler->createSensitiveToken( $this->cardData->cardDetailsJson() ),
			"userId"         => $this->userId,
			"bin"            => substr($this->cardData->pan, 0, 6),
			"last4"          => substr($this->cardData->pan, -4),
		];

//		SchemaHandler::$debugQuery = true;

		$this->call($data);

		$this->deletePublicKey($keyId);
	}

	private function createAndStorePublicKey(string $keyId, string $userId)
	{
		$cmd = new AddPublicKeyToProvisionedUser($keyId, $userId);
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
