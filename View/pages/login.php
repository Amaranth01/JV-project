<?php

require __DIR__ . '/../../partials/header.php';
?>

<!--A form to login-->

    <div>
        <h2 class="subtitle">Connectez-vous</h2>
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
                    <input type="submit" value="Connexion" name="submit" class="button">
                </div>
            </form>
    </div>


    <!--    A button to bring up the login form-->
    <div id="login-button">
        <span>Pas de compte? Créez en un gratuitement !</span>
        <a href="register.php">
            <button id="button-create"> Créer un compte </button>
        </a>
    </div>

<?php
require __DIR__ . '/../../partials/footer.php';