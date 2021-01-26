<?php
$actions = ["login", "logout", "register"];

if( empty($action) || !in_array($action, $actions) ) {
    header("HTTP/1.1 400 Bad Request");
    die("Bad Request");
}

$action = $action;

if( $action === "logout") {
    session_destroy();

    header("Location: " . BASE_PATH);
    exit;
}

require("model/users.php");
$modelUsers = new Users;

$countries = $modelUsers->countries;

if( isset($_POST["send"]) ) {

    if($action === "register") {

        $result = $modelUsers->create( $_POST );

        if($result) {
            header("Location: " .BASE_PATH. "access/login");
        }
        else {
            $message = "Preencha correctamente todos campos";
        }
    }
    elseif($action === "login") {

        $user = $modelUsers->login( $_POST );
        
        if( !empty($user) ) {
            $_SESSION["user_id"] = $user["user_id"];
            header("Location: " .BASE_PATH. "cart");
        }
        else {
            $message = "Email ou password incorrectos.  Tente de novo.";
        }
    }
}


require("view/" .$action. ".php");
