<?php
header("Content-Type: application/json");

if( isset($_POST["request"]) ) {

    if($_POST["request"] === "removeProduct" && !empty($_POST["product_id"])) {
        
        $product_id = (int)$_POST["product_id"];

        unset( $_SESSION["cart"][ $product_id ] );
        
        echo '{"status":"OK", "message":"removed product ' .$product_id. '"}';
    }
    elseif(
        $_POST["request"] === "changeQuantity" &&
        !empty($_POST["product_id"]) &&
        !empty($_POST["quantity"]) &&
        isset($_SESSION["cart"][ $_POST["product_id"] ]) &&
        $_POST["quantity"] > 0
    ) {
        $product_id = (int)$_POST["product_id"];
        $quantity = (int)$_POST["quantity"];

        $_SESSION["cart"][ $product_id ]["quantity"] = $quantity;

        echo '{"status":"OK", "message":"changed quantity to ' .$quantity. ' of product ' .$product_id. '"}';
    }
    else {
        header("HTTP/1.1 400 Bad Request");
        echo '{"status":"Error", "message":"Invalid request"}';
    }
}
else {
    header("HTTP/1.1 400 Bad Request");
    echo '{"status":"Error", "message":"Invalid request"}';    
}
