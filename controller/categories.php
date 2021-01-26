<?php
require("model/categories.php");

$model = new Categories;

if( !empty($action) ) {

    $categories = $model->getSubcategories( $action );

    if( empty($categories) ) {
        header("HTTP/1.1 404 Not Found");
        die("Não encontrado");
    }

    require("view/subcategories.php");
}
else {
    $categories = $model->get();

    require("view/categories.php");
}
