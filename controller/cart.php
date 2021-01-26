<?php

if(isset( $_POST["send"] ) ) {
    $product_id = (int)$_POST["product_id"];
    $quantity = (int)$_POST["quantity"];

    require("model/products.php");
    $modelProducts = new Products;

    $product = $modelProducts->getProductWithinStock( $product_id, $quantity );

    if(!empty($product)) {
        $_SESSION["cart"][ $product_id ] = [
            "quantity" => $quantity,
            "product_id" => $product_id,
            "name" => $product["name"],
            "price" => $product["price"]
        ];
    }
}

require("view/cart.php");
