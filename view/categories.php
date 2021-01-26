<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>Super Store</title>
    </head>
    <body>
        <h1>Escolha a categoria</h1>
        <ul>
<?php
    foreach($categories as $category) {
        echo '
        <li>
            <a href="' .BASE_PATH. 'categories/' .$category["category_id"]. '">' .$category["name"]. '</a>
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
