<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:37
 */

namespace Elo\Api\Cmd;

use Elo\Api\Cmd\VO\UserData;
use Elo\Api\EloClient;
use Elo\Api\Http\EloSessionHandler;

class GetAllServicesByBin extends EloApiCMD
{
    private $bin;

	public function __construct($bin)
	{
		parent::__construct();
		
		$this->isPrivateCall        = false;
        $this->bin                  = $bin;
		$this->graphQLFile          = "getAllServicesByBin";
	}

	public function execute()
	{
        $data['bin']             = $this->bin;

		$this->call($data);
	}
}