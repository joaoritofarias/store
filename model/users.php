<?php
require("base.php");

class Users extends Base
{
    public $countries = ["Portugal", "França", "Espanha", "Dinamarca", "Alemanha", "Holanda", "Itália", "Suécia"];

    public function get() {
        return [];
    }

    public function getItem($id) {
        return [];
    }

    public function create( $user ) {

        $user = $this->sanitize( $user );

        if( $this->validator($user) ) {

            $api_key = bin2hex( random_bytes(32) );

            $query = $this->db->prepare("
                INSERT INTO users
                (name, email, password, phone, address, city, postal_code, country, api_key)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            return $query->execute([
                $user["name"],
                $user["email"],
                password_hash($user["password"], PASSWORD_DEFAULT),
                $user["phone"],
                $user["address"],
                $user["city"],
                $user["postal_code"],
                $user["country"],
                $api_key
            ]);
        }

        return false;
    }

    public function update($id, $user) {
        $user = $this->sanitize( $user );

        if( $this->validator($user) ) {

            $query = $this->db->prepare("
                UPDATE
                    users
                SET
                    name = ?,
                    email = ?,
                    password = ?,
                    phone = ?,
                    address = ?,
                    city = ?,
                    postal_code = ?, 
                    country = ?
                WHERE
                    user_id = ? AND
                    api_key = ?
            ");

            return $query->execute([
                $user["name"],
                $user["email"],
                password_hash($user["password"], PASSWORD_DEFAULT),
                $user["phone"],
                $user["address"],
                $user["city"],
                $user["postal_code"],
                $user["country"],
                $id,
                $user["api_key"]
            ]);
        }

        return false;
    }

    public function delete($id, $api_key) {
        $query = $this->db->prepare("
            DELETE FROM users
            WHERE user_id = ?
              AND api_key = ?
        ");

        return $query->execute([
            $id,
            $api_key
        ]);
    }

    public function login( $user ) {

        $user = $this->sanitize($user);

        if(
            filter_var($user["email"], FILTER_VALIDATE_EMAIL) &&
            mb_strlen($user["password"]) >= 8 &&
            mb_strlen($user["password"]) <= 1000
        ) {
            $query = $this->db->prepare("
                SELECT user_id, password
                FROM users
                WHERE email = ?
            ");

            $query->execute([ $user["email"] ]);

            $existingUser = $query->fetch( PDO::FETCH_ASSOC );

            if(
                !empty($existingUser) &&
                password_verify($user["password"], $existingUser["password"])
            ) {
                return $existingUser;
            }
        }

        return false;
    }

    public function validator($user) {
        if(
            !empty($user["name"]) &&
            !empty($user["password"]) &&
            !empty($user["address"]) &&
            !empty($user["city"]) &&
            !empty($user["postal_code"]) &&
            mb_strlen($user["name"]) > 2 &&
            mb_strlen($user["name"]) <= 64 &&
            mb_strlen($user["password"]) >= 8 &&
            mb_strlen($user["password"]) <= 1000 &&
            mb_strlen($user["address"]) <= 255 &&
            mb_strlen($user["city"]) <= 64 &&
            mb_strlen($user["postal_code"]) <= 32 &&
            filter_var($user["email"], FILTER_VALIDATE_EMAIL) &&
            $user["password"] === $user["rep_password"] &&
            in_array($user["country"], $this->countries)
        ) {
            return true;
        }

        return false;
    }
}
