<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title><?php echo $categories[0]["parent_name"]; ?></title>
    </head>
    <body>
        <h1><?php echo $categories[0]["parent_name"]; ?></h1>
        <ul>
<?php
    foreach($categories as $category) {
        echo '
        <li>
            <a href="' .BASE_PATH. 'products/' .$category["category_id"]. '">' .$category["name"]. '</a>
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