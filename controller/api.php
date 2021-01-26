<?php
header("Content-Type: application/json");

$response = [];

if( !empty($url_parts[5] ) ) {
    $id = (int)$url_parts[5];
}

if( in_array($action, $controllers) ) {
    
    require("model/" .$action. ".php");

    $className = ucwords($action); // ex: products <=> Products

    $model = new $className; // ex: new Products

    // confirmar que o utilizador tem permissão caso seja algo de escrita
    if(
        ($action === "users" && $_SERVER["REQUEST_METHOD"] !== "POST") ||
        ($action !== "users" && in_array($_SERVER["REQUEST_METHOD"], ["POST", "PUT", "DELETE"]))
    ) {

        // API key vem por Header de HTTP, temos que a obter para validar
        $headers = apache_request_headers();
        foreach($headers as $key => $value) {
            if( strtolower($key) === "x-auth-token") {
                $token = $value;
            }
        }

        if(
            !isset($token) ||
            empty($model->decodeToken($token))
        ) {
            header("HTTP/1.1 401 Unauthorized");
            die('{"message":"Unauthorized"}');
        }

        $decoded = $model->decodeToken($token);
        $api_key = $decoded["api_key"];
    }

    if($_SERVER["REQUEST_METHOD"] === "GET") {
        if(!empty($id)) {
            $response = $model->getItem($id);
        }
        else {
            $response = $model->get();
        }

        if(empty($response)) {
            header("HTTP/1.1 404 Not Found");

            $response["message"] = "404 Not Found";
        }
    }
    else if($_SERVER["REQUEST_METHOD"] === "POST") {

        $data = json_decode(file_get_contents("php://input"), true);
        
        if(!empty($data)) {

            if(!empty($api_key)) {
                $data["api_key"] = $api_key;
            }

            $status = $model->create( $data );
        }

        if(!empty($status)) {
            header("HTTP/1.1 202 Accepted");
            $response = $data;
        }
        else {
            header("HTTP/1.1 400 Bad Request");
            $response["message"] = "Invalid Data";
        }
    }
    else if($_SERVER["REQUEST_METHOD"] === "PUT") {

        $data = json_decode(file_get_contents("php://input"), true);
        
        $data["api_key"] = $api_key;

        if(!empty($data) && !empty($id)) {
            $status = $model->update( $id, $data );
        }

        if(!empty($status)) {
            header("HTTP/1.1 202 Accepted");
            $response = $data;
        }
        else {
            header("HTTP/1.1 400 Bad Request");
            $response["message"] = "Invalid Data";
        }
    }
    else if($_SERVER["REQUEST_METHOD"] === "DELETE") {
        if(!empty($id)) {
            $result = $model->delete($id, $api_key);
        }

        if(!empty($result)) {
            header("HTTP/1.1 202 Accepted");
            $response["message"] = "Deleted";
        }
        else {
            header("HTTP/1.1 400 Bad Request");
            $response["message"] = "Missing ID";
        }
    }
    else {
        header("HTTP/1.1 405 Method Not Allowed");
        $response["message"] = "405 Method Not Allowed";
    }
}
else {
    header("HTTP/1.1 400 Bad Request");

    $response["message"] = "400 Bad Request";
}

echo json_encode( $response );
