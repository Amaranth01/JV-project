<h1>Inscrivez-vous</h1>
<!--A form to register-->
<div>
    <form action="/index.php?c=user&a=register" method="post">

        <div>
            <label for="usernameRegister">Votre pseudo</label>
            <input type="text" name="username" id="usernameRegister" required>
        </div>

        <div>
            <label for="email-register">Votre email</label>
            <input type="email" name="email" id="email-register" required>
        </div>

        <div>
            <label for="passwordRegister">Votre mot de passe</label>
            <input type="password" name="password" id="passwordRegister" required>
        </div>

        <div>
            <label for="passwordRegisterRepeat">Répétez votre mot de passe</label>
            <input type="password" name="passwordR" id="passwordRegisterRepeat" required>
        </div>

        <div>
            <input type="submit" name="submit" value="Inscription" class="button">
        </div>

    </form>
</div>