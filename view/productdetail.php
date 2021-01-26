<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title><?php echo $product["name"]; ?></title>
        <style>
            .add_cart {
                border: 1px solid #999;
                background-color: #CCC;
                max-width: 100%;
                width: 40vw;
                padding: 10px;
                margin: 20px 0;
            }
        </style>
    </head>
    <body>
        <main>
            <h1><?php echo $product["name"]; ?></h1>
            <div class="description"><?php echo $product["description"]; ?></div>
            <div class="price"><?php echo $product["price"]; ?>€</div>
            <form method="post" action="<?=BASE_PATH?>cart">
<?php
    if($product["stock"] > 0) {
?>
            <div class="add_cart">
                <div>
                    <label>
                        Quantidade
                        <input type="number" name="quantity" min="1" max="<?php echo $product["stock"]; ?>" value="1">
                    </label>
                </div>
                <div>
                    <input type="hidden" name="product_id" value="<?php echo $product["product_id"]; ?>">
                    <button type="submit" name="send">Adicionar ao Carrinho</button>
                </div>
            </div>
<?php
    }
    else {
        echo "<h2>Esgotado</h2>";
    }
?>
            </form>
            <div class="image">
                <img src="<?=BASE_PATH?>images/<?php echo $product["image"]; ?>" alt="">
            </div>
        </main>
<?php
    include("menu.php");
?>
    </body>
</html>
