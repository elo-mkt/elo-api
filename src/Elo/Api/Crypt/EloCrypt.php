<?php
/**
 * Created by IntelliJ IDEA.
 * User: guilhon
 * Date: 02/02/18
 * Time: 21:54
 */

namespace Elo\Api\Crypt;


class EloCrypt
{
    private $bcrypt;

    public function __construct()
    {
        $this->bcrypt = new BCrypt();
    }

    private function sha256AsBase64($data) {
        $base64 = hash('sha256', $data, true);
        return base64_encode($base64);
    }
	
    private function bcryptSaltFromUsername($userName)
    {
        $hash = hash('sha256', $userName);
        $base = $this->bcrypt->encodeBase64($hash, 16);
        return  '$2a$12$' . $base;
    }
	
    public function bcryptUserPassword($username, $password)
    {
        $userSalt = $this->bcryptSaltFromUsername($username);
        return $this->bcrypt->hashSync($this->sha256AsBase64($password), $userSalt);
    }
	
    public function bcryptChallengePasswordSync($bcryptPassword, $salt)
    {
        return $this->bcrypt->hashSync($bcryptPassword, $salt);
    }
}