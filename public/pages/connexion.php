<?php

require __DIR__ . '/../../partials/header.php';
?>

<!--A form to login-->
<div>
    <h2>Connectez-vous</h2>
        <form action="/forms/form-login.php" method="post">
            <div>
                <label for="username-login">Votre pseudo</label>
                <input type="text" name="username" id="username-login">
            </div>

            <div>
                <label for="user-password">Votre mot de passe</label>
                <input type="password" name="password" id="user-password">
            </div>

            <div>
                <input type="submit" value="Connexion" name="submit">
            </div>
        </form>
</div>
<!--A form to register-->
<div>
    <h2>Inscrivez-vous</h2>
    <form action="/forms/form-register.php" method="post">

        <div>
            <label for="username-register">Votre pseudo</label>
            <input type="text" name="username" id="username-register">
        </div>

        <div>
            <label for="email-register">Votre email</label>
            <input type="email" name="email" id="email-register">
        </div>

        <div>
            <label for="password-register">Votre mot de passe</label>
            <input type="password" name="password" id="password-register">
        </div>

        <div>
            <label for="password-register-repeat">Répétez votre mot de passe</label>
            <input type="password" name="password-repeat" id="password-register-repeat">
        </div>

    </form>
</div>

<!--    A button to bring up the login form-->
<div id="login-button">
    <span>Pas de compte? Créez en un gratuitement !</span>
    <button>Inscription</button>
</div>

<?php
require __DIR__ . '/../../partials/footer.php';