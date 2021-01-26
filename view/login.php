<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>Efectuar Login</title>
    </head>
    <body>
        <h1>Efectuar Login</h1>
<?php
    if(isset($message)) {
        echo '<p role="alert">' .$message. '</p>';
    }
?>
        <p>Se ainda não tiver uma conta, <a href="<?=BASE_PATH?>access/register">crie uma aqui</a>.</p>
        <form method="post" action="<?=BASE_PATH?>access/login">
            <div>
                <label>
                    Email
                    <input type="email" name="email" required autofocus>
                </label>
            </div>
            <div>
                <label>
                    Password
                    <input type="password" name="password" minlength="8" maxlength="1000" required>
                </label>
            </div>
            <div>
                <button type="submit" name="send">Login</button>
            </div>
        </form>
    </body>
</html>