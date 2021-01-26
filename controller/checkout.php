<?php
if( !isset($_SESSION["user_id"]) ) {
    header("Location: " .BASE_PATH. "access/login");
    exit;
}

if(!empty($_SESSION["cart"])) {

    require("model/orders.php");
    $modelOrders = new Orders;

    $order_id = $modelOrders->create( $_SESSION["cart"] );

    if(!empty( $order_id )) {

        unset($_SESSION["cart"]);

        $message = "A sua encomenda número " .$order_id. " foi efecutada com sucesso. Seguem os dados para pagamento: XPTOCENAS";
    }
    else {
        $message = "Ocorreu um erro com a sua encomenda";
    }
}
else {
    header("Location: " .BASE_PATH. "cart");
    exit;
}

require("view/checkout.php");
