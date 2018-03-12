<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 10:39
 */

namespace Elo\Api\Cmd;


class RequestPasswordRequestByEmail extends EloApiCMD
{
	private $cpf;
	private $email;
	
	public function __construct(string $cpf, string $email)
	{
		parent::__construct();
		
		$this->cpf = $cpf;
		$this->email = $email;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'requestPasswordResetByEmail';
	}
	
	public function execute()
	{
		$this->call([
			'cpf' => $this->cpf,
			'email' => $this->email
		]);
	}
}