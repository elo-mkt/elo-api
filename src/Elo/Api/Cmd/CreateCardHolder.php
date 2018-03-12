<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 16:25
 */

namespace Elo\Api\Cmd;


use Elo\Api\Http\EloSessionHandler;

class CreateCardHolder extends EloApiCMD
{
	public function __construct()
	{
		parent::__construct();
		
		$this->isPrivateCall = true;
		$this->graphQLFile = 'createCardHolder';
	}
	
	public function execute()
	{
		$this->call(['access_token'=>EloSessionHandler::get('accessToken')]);
		
//		$access_token = session('accessToken');
//		$query = '{"query":" mutation{ createCardHolderForUser(input:{ clientMutationId: \"1234567890\", userId: \"$access_token\"}) { user{ id, username, firstName, lastName, displayName }, cardHolder{ id, name, firstName, lastName, displayName, legalIds {cpf{number}}}}}","variables":""}';
//		$body = str_replace('$access_token', $access_token, $query);
////        echo $body;exit;
//		
//		$res = $this->httpClient->request('POST', $this->PRIVATE_URL, [
//			'headers' => $this->getHeaderWithAccessToken(),
//			'body'    => $body
//		]);
//		
//		$result = json_decode($res->getBody());
//		
//		$errors = $this->getResultErrors($result);
//		if($errors)
//			return $errors;
		
		return null;
	}
}