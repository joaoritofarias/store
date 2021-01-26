<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>Carrinho</title>
        <style>
            table, tr, td, th { border: 1px solid #000; border-collapse: collapse; }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                
                const removeButtons = document.querySelectorAll(".remove");
                const quantityInputs = document.querySelectorAll('input[name="quantity"]');
                
                for(let button of removeButtons) {

                    button.addEventListener("click", () => {
                        const tr = button.parentNode.parentNode;
                        const product_id = tr.dataset.product_id;
                        
                        const requestBody = "request=removeProduct&product_id="+product_id;

                        fetch("<?=BASE_PATH?>requests", {
                            "method":"POST",
                            "headers": {
                                "Content-Type":"application/x-www-form-urlencoded"
                            },
                            "body":requestBody,
                            "credentials":"same-origin"
                        })
                        .then( response => response.json() )
                        .then( json => {
                            if(json.status === "OK") {
                                tr.remove();

                                calculateTotal();
                            }
                            
                        } );
                    });
                }
                
                for(let input of quantityInputs) {
                    
                    input.addEventListener("change", () => {
                        const tr = input.parentNode.parentNode;
                        const product_id = tr.dataset.product_id;
                        const quantity = input.value;
                        
                        const requestBody = "request=changeQuantity&product_id="+product_id+"&quantity="+quantity;

                        fetch("<?=BASE_PATH?>requests", {
                            "method":"POST",
                            "headers": {
                                "Content-Type":"application/x-www-form-urlencoded"
                            },
                            "body":requestBody,
                            "credentials":"same-origin"
                        })
                        .then( response => response.json() )
                        .then( json => {
                            /*
                                1) obter preço individual
                                2) calcular preço * quantidade
                                3) colocar no elemento de HTML que demos nome de subtotal
                                4) modificar o total de tudo
                            */
                            const price = tr.dataset.price;
                            const subtotal = price * quantity;

                            tr.querySelector(".subtotal").textContent = subtotal;

                            calculateTotal();
                        } );
                    });
                }
                
                function calculateTotal() {
                    let total = 0;

                    const quantityInputs = document.querySelectorAll('input[name="quantity"]');

                    for(let input of quantityInputs) {
                        const quantity = input.value;
                        const price = input.parentNode.parentNode.dataset.price;

                        total += quantity * price;
                    }
                    
                    document.querySelector(".total").textContent = total;
                }
            });
        </script>
    </head>
    <body>
<?php
    if(empty($_SESSION["cart"])) {
        echo "<p>Ainda não colocou qualquer artigo no carrinho.</p>";
    }
    else {
?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Total</th>
                <th>Apagar</th>
            </tr>
<?php
        $total = 0;
        foreach($_SESSION["cart"] as $item) {
            //$total = $total + ($item["quantity"] * $item["price"]);
            $total += $item["quantity"] * $item["price"];
?>
            <tr data-product_id="<?php echo $item["product_id"]; ?>" data-price="<?php echo $item["price"]; ?>">
                <td><?php echo $item["name"]; ?></td>
                <td>
                    <input type="number" name="quantity" value="<?php echo $item["quantity"]; ?>" min="1" max="99">
                </td>
                <td><?php echo $item["price"]; ?>€</td>
                <td>
                    <span class="subtotal"><?php echo $item["quantity"] * $item["price"]; ?></span>€
                </td>
                <td>
                    <button type="button" class="remove">X</button>
                </td>
            </tr>
<?php
        }
?>
            <tr>
                <td colspan="3"></td>
                <td colspan="2">
                    <span class="total"><?php echo $total; ?></span>€
                </td>
            </tr>
        </table>
<?php
    }
?>
        <nav>
            <a href="<?=BASE_PATH?>">Voltar à Homepage</a>
            <a href="<?=BASE_PATH?>checkout">Finalizar a Encomenda</a>
        </nav>
    </body>
</html>
