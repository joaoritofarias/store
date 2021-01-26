<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title><?php echo $products[0]["category"]; ?></title>
    </head>
    <body>
        <h1><?php echo $products[0]["category"]; ?></h1>
        <ul>
<?php
    foreach($products as $product) {
        echo '
        <li>
            <a href="' .BASE_PATH. 'product/' .$product["product_id"]. '">' .$product["name"]. '</a>
        </li>
        ';
    }
?>
        </ul>
<?php
    include("menu.php");
?>
    </body>
</html>