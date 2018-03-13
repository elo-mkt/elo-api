<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 13/03/18
 * Time: 19:42
 */

namespace Elo\Api\Cmd;


use Elo\Api\EloClient;
use Elo\Api\Http\EloResponse;
use Elo\Api\Http\EloSessionHandler;

class GetCPF extends EloApiCMD
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function execute()
	{
		$eloClient = new EloClient();
		if(!$eloClient->isLogged())
			throw new \Exception('User is not logged in.');
		
		$cpf = EloSessionHandler::get('cpf');
		
		if(!is_null($cpf))
		{
			$this->setCPF($cpf);
			return;
		}
		
		if(is_null($cpf) && !is_null(EloSessionHandler::get('accessToken')))
		{
			$response = $eloClient->getProfile();
			
			if($response->isSuccess())
				$cpf = $response->getData()->user->legalIds->cpf->number;
		}
		
		if(!is_null($cpf))
		{
			EloSessionHandler::set(['cpf'=>$cpf]);
			$this->setCPF($cpf);
		}
	}
	
	private function setCPF($cpf)
	{
		$this->response = EloResponse::create( (object)['data'=>$cpf] );
	}
}