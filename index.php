<?php
session_start();

//define("BASE_PATH", "/flag/storeMVCPermalinks/");
define("BASE_PATH", dirname($_SERVER["SCRIPT_NAME"]) . "/" );

$url_parts = explode("/", $_SERVER["REQUEST_URI"]);

$controllers = [
    "access",
    "auth",
    "api",
    "cart",
    "categories",
    "checkout",
    "orders",
    "product",
    "products",
    "requests",
    "users"
];

/* default */
$controller = "categories";

if( !empty($url_parts[3]) ) {

    if( !in_array($url_parts[3], $controllers) ) {
        header("HTTP/1.1 404 Not Found");
        die("404 Not Found");
    }
    
    $controller = $url_parts[3];
}

if( isset($url_parts[4]) ) {
    $action = $url_parts[4];
}

$cart_count = 0;
if(isset($_SESSION["cart"])) {
    $cart_count = count($_SESSION["cart"]);
}

require("controller/" .$controller. ".php");
