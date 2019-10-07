<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 10/03/18
 * Time: 17:52
 */

namespace Elo\Api\Cmd;

use Elo\Api\Cmd\VO\ProvisionedUserData;
use Elo\Api\Cmd\VO\UserData;

class GetProvisionedOrigin extends EloApiCMD
{
	/** @var UserData  */
	private $origin;

	public function __construct($origin)
	{
		parent::__construct();
		$this->origin = $origin;
		$this->isPrivateCall = true;
		$this->graphQLFile = 'getProvisionedOrigin';
	}

	public function execute()
	{
        $data = [
            'origin' => $this->origin
        ];

		$this->call($data);
	}
}
