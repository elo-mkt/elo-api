<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:32
 */

namespace Elo\Api\Cmd;


use Elo\Api\Http\EloHttpClient;
use Elo\Api\Http\EloResponse;
use Elo\Api\SchemeHandler;
use GuzzleHttp\Client;

abstract class EloApiCMD
{
	/**
	 * @var Client
	 */
	protected $httpClient;
	
	/** @var bool */
	protected $isPrivateCall = false;
	
	/** @var string */
	protected $method = 'POST';
	
	/** @var  string */
	protected $graphQLFile;
	
	/** @var  EloResponse */
	public $response;
	
	public function __construct()
	{
		$this->httpClient = new Client();
	}
	
	abstract public function execute();
	
	/**
	 * @return bool
	 */
	public function hasErrors()
	{
		return $this->response && $this->response->hasErrors();
	}
	
	/**
	 * @return bool
	 */
	public function failed()
	{
		return $this->hasErrors() && !$this->response->isSuccess();
	}
	
	/**
	 * @return bool
	 */
	public function succeeded()
	{
		return !$this->hasErrors() && $this->response->isSuccess();
	}
	
	public function getData()
	{
		if($this->response->isSuccess())
			return $this->response->getData();
		return null;
	}
	
	public function getErrorData()
	{
		if($this->hasErrors())
			return $this->response->getErrors();
		return null;
	}
	
	public function getFirstErrorMessage()
	{
		if($this->hasErrors())
			return $this->response->firstErrorMessage();
		return null;
	}
	
	protected function call(array $data = [])
	{
		$payload = SchemeHandler::getScheme($this->graphQLFile, $data);
		
		if($this->isPrivateCall)
			return $this->privateCall($payload, $this->method);
		
		return $this->publicCall($payload, $this->method);
	}
	
	protected function publicCall($body, $method = "POST")
	{
		$this->response = EloHttpClient::publicCall($body, $method);
		return $this->response;
	}
	
	protected function privateCall($body, $method = 'POST')
	{
		$this->response = EloHttpClient::privateCall($body, $method);
		return $this->response;
	}
}