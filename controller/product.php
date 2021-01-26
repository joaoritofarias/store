<?php
require("model/products.php");

$model = new Products;

if( !empty($action) ) {

    $product = $model->getProduct( $action );

    if( empty($product) ) {
        header("HTTP/1.1 404 Not Found");
        die("Não encontrado");
    }

    require("view/productdetail.php");
}
else {
    header("HTTP/1.1 400 Bad Request");
    die("Bad request");
}
