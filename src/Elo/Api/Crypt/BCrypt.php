<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 01/02/18
 * Time: 17:58
 */

namespace Elo\Api\Crypt;


class BCrypt
{
	const BCRYPT_SALT_LEN = 16;
	const GENSALT_DEFAULT_LOG2_ROUNDS = 10;
	
	public function hashSync ($s, $salt = null) 
	{
		require 'password.php';
		
		if (!$salt)
	        $salt = self::GENSALT_DEFAULT_LOG2_ROUNDS;
	    
		if (is_numeric($salt))
	        $salt = $this->genSaltSync($salt);
	    
	    if (!is_string($s) || !is_string($salt))
	        throw new \Exception("Illegal arguments");
	    
	    $options = [];
	    
	    if($salt)
	    {
		    $options['saltType'] = substr($salt, 0, 3);
		    $options['cost'] = substr($salt, 4, 2);
		    $options['salt'] = substr($salt, 7);
	    }
		
	    return password_hash2($s, PASSWORD_BCRYPT, $options);
	}
	
	private function genSaltSync($rounds, $seed_length = null) 
	{
		$rounds = $rounds ? $rounds : self::GENSALT_DEFAULT_LOG2_ROUNDS;
		
		if (!is_numeric( $rounds ) )
	        throw new \Exception("Illegal arguments");
		
	    if ($rounds < 4) $rounds = 4;
	    if ($rounds > 31) $rounds = 31;
	    
	    $salt = [];
	    $salt[] = "$2a$";
	    
	    if ($rounds < 10)
		    $salt[] = "0";
	    
	    $salt[] = (string) $rounds;
	    $salt[] = '$';
	    $salt[] = $this->base64_encode(random_bytes(self::BCRYPT_SALT_LEN), self::BCRYPT_SALT_LEN);
	    return join('', $salt);
	}
	
	private function base64_encode($b, $len)
	{
		$BASE64_CODE = str_split("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789");
		$b = str_split($b, 2);
		$off = 0;
		$rs = [];
		
		if ($len <= 0 || $len > count($b))
			throw new \Exception("Illegal len: " + $len);
		
		while ($off < $len) {
			$c1 = intval($b[$off++], 16) & 0xff;
			$rs[] = $BASE64_CODE[($c1 >> 2) & 0x3f];
			$c1 = (intval($c1, 16) & 0x03) << 4;
			if ($off >= $len) {
				$rs[] = $BASE64_CODE[$c1 & 0x3f];
				break;
			}
			$c2 = intval($b[$off++], 16) & 0xff;
			$c1 |= ($c2 >> 4) & 0x0f;
			$rs[] = $BASE64_CODE[$c1 & 0x3f];
			$c1 = ($c2 & 0x0f) << 2;
			if ($off >= $len) {
				$rs[] = $BASE64_CODE[$c1 & 0x3f];
				break;
			}
			$c2 = intval($b[$off++], 16) & 0xff;
			$c1 |= ($c2 >> 6) & 0x03;
			$rs[] = $BASE64_CODE[$c1 & 0x3f];
			$rs[] = $BASE64_CODE[$c2 & 0x3f];
		}
		return join('', $rs);
	}
	
	public function encodeBase64($b, $len)
	{
		return $this->base64_encode($b, $len);
	}
}