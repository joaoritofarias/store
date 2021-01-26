<?php
require("model/products.php");

$model = new Products;

if( !empty($action) ) {

    $products = $model->getProducts( $action );

    if( empty($products) ) {
        header("HTTP/1.1 404 Not Found");
        die("Não encontrado");
    }

    require("view/products.php");
}
else {
    header("HTTP/1.1 400 Bad Request");
    die("Bad request");
}
