<?php
header("Content-Type: application/json");

require("model/auth.php");

$model = new Auth;

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);
    
    if(!empty($data)) {
        $token = $model->login($data);
        echo '{"X-Auth-Token":"' .$token. '"}';
    }
}
