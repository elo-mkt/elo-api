<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 12/03/18
 * Time: 10:39
 */

namespace Elo\Api\Cmd;


class RequestPasswordReset extends EloApiCMD
{
	private $cpf;
	private $type;

	public function __construct(string $cpf, string $type)
	{
		parent::__construct();
		
		$this->cpf = $cpf;
		$this->type = strtoupper($type);
		$this->isPrivateCall = true;
		$this->graphQLFile = 'requestPasswordReset';
	}
	
	public function execute()
	{
		$this->call([
			'cpf' => $this->cpf,
			'type' => $this->type
		]);
	}
}