<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 09/03/18
 * Time: 08:14
 */

namespace Elo\Api\Http;


use Elo\Api\Cmd\EloApiCMD;

class EloResponse
{
	public static $REQUESTS = [];
	public static $ERRORS = [];
	
	private $errors;
	private $data;
	public $requestData;
	public $responseData;
	
	/** @var  EloApiCMD */
	public $command;
	
	/**
	 * Clears all previous errors.
	 */
	public static function clearErrors()
	{
		self::$ERRORS = [];
	}
	
	/**
	 * @param $data
	 * @param array|null $requestData
	 * @return EloResponse
	 */
	public static function create($data, array $requestData = null)
	{
		$response = new EloResponse();
		$response->requestData = $requestData;
		$response->responseData = $data;
		
		$REQUESTS[] = [
			'request' => $requestData,
			'response' => $data,
		];
		
		if(property_exists($data, 'errors') && $data->errors)
		{
			$response->errors = $data->errors;
			self::$ERRORS = array_merge(self::$ERRORS, $response->parseErrorData($data->errors));
		}

		if(property_exists($data, 'data') && $data->data)
			$response->data = $data->data;
		
		return $response;
	}
	
	private function parseErrorData($errors)
	{
		$parsedErrors = [];
		
		foreach ($errors as $error)
		{
			try
			{
				$msgObject = json_decode($error->message);
				
				if(is_array($msgObject))
					$msgObject = $msgObject[0];
				
				if(is_object($msgObject) && property_exists($msgObject, 'code'))
				{
					$error = (array) $error;
					$error['code'] = $msgObject->code;
				}
			}
			catch(\Exception $e)
			{
				$error = (array) $error;
				$error['code'] = '999';
			}
			
			$parsedErrors[] = (object) $error;
		}
		
		return $parsedErrors;
	}
	
	public function hasData()
	{
		return $this->data != null;
	}
	
	public function hasErrors()
	{
		return $this->errors != null;
	}
	
	public function isSuccess()
	{
		return $this->data != null;
	}
	
	public function firstErrorMessage()
	{
		if($this->errors) 
		{
			try
			{
				$msgObject = json_decode($this->errors[0]->message);
				
				if(is_array($msgObject))
					$msgObject = $msgObject[0];
				
				if(is_object($msgObject) && property_exists($msgObject, 'description'))
					return $msgObject->description;
				
				if(is_object($msgObject) && property_exists($msgObject, 'error'))
					return $msgObject->error;
			}
			catch(\Exception $e)
			{
				
			}
			
			if(is_array($this->errors[0]->message))
				return $this->errors[0]->message->description;
			
			return $this->errors[0]->message;
		}
		
		return null;
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	public function getJsonData()
	{
		return json_encode($this->data);
	}
	
	public function getErrors()
	{
		return $this->errors;
	}
	
	public function getJsonErrors()
	{
		return json_encode($this->errors);
	}
	
	public function getJsonRequestAndResponseData()
	{
		$data = [
			'request' => $this->requestData,
			'errors' => $this->errors,
			'response' => $this->data,
		];
		
		if($this->hasErrors())
			$data['errorMessage'] = $this->firstErrorMessage();
		
		return json_encode($data);
	}
}