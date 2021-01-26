<?php
require("base.php");

use ReallySimpleJWT\Token;

require 'vendor/autoload.php';

class Auth extends Base
{
    public function login($user) {
        $token = "";

        $query = $this->db->prepare("
            SELECT user_id, name, password, api_key
            FROM users
            WHERE email = ?
        ");

        $query->execute([
            $user["email"]
        ]);

        $userDb = $query->fetch( PDO::FETCH_ASSOC );
        if(
            !empty($userDb) &&
            password_verify(
                $user["password"],
                $userDb["password"]
            )
        ) {

            $secret = 'sec!ReT423*&';
            $payload = [
                'iat' => time(),
                'user_id' => $userDb["user_id"],
                'name' => $userDb["name"],
                'api_key' => $userDb["api_key"],
                'exp' => time() + 3600,
                'iss' => 'localhost'
            ];

            $token = Token::customPayload($payload, $secret);
        }

        return $token;
    }

}






