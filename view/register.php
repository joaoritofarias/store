<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>Criar Conta</title>
    </head>
    <body>
        <h1>Criar Conta</h1>
<?php
    if(isset($message)) { echo '<p role="alert">' .$message. '</p>'; }
?>
        <p>Se já tiver uma conta, <a href="<?=BASE_PATH?>access/login">faça login</a>.</p>
        <form method="post" action="<?=BASE_PATH?>access/register">
            <div>
                <label>
                    Nome
                    <input type="text" name="name" required minlength="2" maxlength="64">
                </label>
            </div>
            <div>
                <label>
                    Email
                    <input type="email" name="email" required>
                </label>
            </div>
            <div>
                <label>
                    Password
                    <input type="password" name="password" required minlength="8" maxlength="1000">
                </label>
            </div>
            <div>
                <label>
                    Repetir Password
                    <input type="password" name="rep_password" required minlength="8" maxlength="1000">
                </label>
            </div>
            <div>
                <label>
                    Telefone
                    <input type="text" name="phone" maxlength="32">
                </label>
            </div>
            <div>
                <label>
                    Morada
                    <input type="text" name="address" maxlength="255" required>
                </label>
            </div>
            <div>
                <label>
                    Cidade
                    <input type="text" name="city" maxlength="64" required>
                </label>
            </div>
            <div>
                <label>
                    Código Postal
                    <input type="text" name="postal_code" maxlength="32" required>
                </label>
            </div>
            <div>
                <label>
                    País
                    <select name="country">
<?php
    foreach($countries as $country) {
        echo '<option>' .$country. '</option>';
    }
?>
                    </select>
                </label>
            </div>
            <div>
                <button type="submit" name="send">Registar</button>
            </div>
        </form>
    </body>
</html>