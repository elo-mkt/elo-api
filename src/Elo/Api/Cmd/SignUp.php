<?php

namespace Elo\Api\Cmd;

use Elo\Api\Crypt\EloCrypt;
use Elo\Api\SchemeHandler;
use Elo\Api\Http\EloSessionHandler;

/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:26
 */

class SignUp extends EloApiCMD
{
	private $signUpData;
	
	public function __construct($signUpData)
	{
		parent::__construct();
		$this->signUpData = $signUpData;
		$this->isPrivateCall = false;
		$this->graphQLFile = "createUser";
	}
	
	public function execute()
	{
		$eloCrypt = new EloCrypt();
		$data = new \ArrayObject($this->signUpData);
		$data['password'] = $eloCrypt->bcryptUserPassword($this->signUpData['username'], $data['password']);
		
		$this->call( (array) $data);
		
		if($this->failed())
			return;
		
		EloSessionHandler::set([
			'userId'      => $this->getData()->createUser->id,
			'userName'    => $this->getData()->createUser->name,
			'accessToken' => $this->getData()->createUser->id,
		]);
		
		$this->createCardHolders();
		
//		$query = '{"query":"mutation{  createUser(input:  {  clientMutationId:\"051\", name:\"$name\", username: \"$username\", bcryptPassword: \"$password\", firstName: \"$firstname\",  lastName: \"$lastname\",  displayName: \"$displayname\", birthday: \"$birthday\", legalIds:{ cpf: \"$cpf\", rg:{ number: \"$rgNumber\", issuerOrganization: \"$issuerOrganization\", issuerState: \"$issuerState\", issueDate: \"$issueDate\" }  },  contacts:[{ type:EMAIL, context: \"$emailContext\", value: \"$email\"  },{ type:PHONE, context: \"$phoneContext\", value: \"$phone\"  }],  addresses:{ context: \"$addressContext\", country: \"BRL\", city: \"$city\", state: \"$state\", stateAbbrev:\"$statecode\", zip: \"$zip\", number: $number, place: \"$place\", complement: \"$complement\"}}) { id, name } }","variables":""}';
//		$body = $this->getProfileBody($request, $query);
////        echo $body;exit;
//		
//		$res = $this->httpClient->request('POST', $this->PUBLIC_URL, [
//			'headers' => $this->getHeader(),
//			'body'    => $body
//		]);
//		
//		$result = json_decode($res->getBody());
//		
//		$errors = $this->getResultErrors($result);
//		if($errors)
//			return $errors;
//		
//		$request->session()->put('userId', $result->data->createUser->id);
//		$request->session()->put('userName', $result->data->createUser->name);
//		$this->doLogin($request->username, $request->password);
//		
//		$this->createCardHolder();
//		$this->createPrivateAndPublicKey();
		
//		if($request->has('check-offers') && $request->input('check-offers') == 'on')
//			$this->subscribeToNewsletter($result->data->createUser->id, $request->email);
		
		return null;
	}
	
	private function createCardHolders()
	{
		$cmd = new CreateCardHolder();
		$cmd->execute();
	}
}