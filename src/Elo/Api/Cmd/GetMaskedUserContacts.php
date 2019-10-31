<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 26/03/18
 * Time: 11:52
 */

namespace Elo\Api\Cmd;


class GetMaskedUserContacts extends EloApiCMD
{
    private $cpf;

	public function __construct($cpf)
	{
		parent::__construct();
		$this->cpf = $cpf;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'maskedUserContacts';
	}
	
	public function execute()
	{
		$this->call([
		    'cpf'   => $this->cpf
        ]);
	}
}