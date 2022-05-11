<h1 class="subtitle">Connectez-vous</h1>
<!--A form to login-->
    <div>

            <form action="/index.php?c=user&a=connexion" method="post">
                <div>
                    <label for="username-login">Votre pseudo</label>
                    <input type="text" name="username" id="username-login" required>
                </div>

                <div>
                    <label for="userPassword">Votre mot de passe</label>
                    <input type="password" name="password" id="userPassword" required>
                </div>

                <div>
                    <input type="submit" name="submit" value="Connexion" class="button">
                </div>
            </form>
    </div>


    <!--    A button to bring up the login form-->
    <div>
        <p class="account">Pas de compte? Créez en un gratuitement !
            <a href="/index.php?c=home&a=register" class="createAccount">Créer un compte</a>
        </p>

    </div>