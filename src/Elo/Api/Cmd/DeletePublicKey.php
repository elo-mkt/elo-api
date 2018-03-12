<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 21:00
 */

namespace Elo\Api\Cmd;


use Elo\Api\Http\EloSessionHandler;

class DeletePublicKey extends EloApiCMD
{
	private $keyId;
	
	public function __construct($keyId)
	{
		parent::__construct();
		$this->keyId = $keyId;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'deletePublicKey';
	}
	
	public function execute()
	{
		$this->call([
			'access_token' => EloSessionHandler::get('accessToken'),
			'key_id' => $this->keyId
		]);
	}
}