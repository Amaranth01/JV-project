<h1 class="subtitle">Connectez-vous</h1>
<!--A form to login-->
    <div>

            <form action="/index.php?c=user&a=connexion" method="post">
                <div>
                    <label for="username">Votre pseudo</label>
                    <input type="text" name="username" id="username" >
                </div>

                <div>
                    <label for="Password">Votre mot de passe</label>
                    <input type="password" name="password" id="Password" required>
                </div>

                <div>
                    <input type="submit" name="submit" value="Connexion" id="buttonForm" class="button">
                </div>
            </form>
    </div>


    <!--    A button to bring up the login form-->
    <div>
        <p class="account">Pas de compte? Créez en un gratuitement !
            <a href="/index.php?c=home&a=register" class="createAccount">Créer un compte</a>
        </p>

        <p>
            <a href="/index.php?c=home&a=check-email" id="forgot"> Mot de passe oublié ?</a>
        </p>

    </div>