        <nav>
<?php
    if(!isset($_SESSION["user_id"])) {
?>
            <a href="<?=BASE_PATH?>access/login">Login</a>
            <a href="<?=BASE_PATH?>access/register">Criar Conta</a>
<?php
    }
    else {
?>
            <a href="<?=BASE_PATH?>access/logout">Logout</a>
<?php
    }
?>
            <a href="<?=BASE_PATH?>cart">Ver Carrinho (<?php echo $cart_count; ?>)</a>
        </nav>
