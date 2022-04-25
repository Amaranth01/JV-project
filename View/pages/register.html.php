<h1>Inscrivez-vous</h1>
<!--A form to register-->
<div>
    <form action="/index.php?c=user&a=register" method="post">

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
            <label for="passwordRegisterRepeat">Répétez votre mot de passe</label>
            <input type="password" name="passwordR" id="passwordRegisterRepeat">
        </div>

        <div>
            <input type="submit" name="submit" value="Inscription" class="button">
        </div>

    </form>
</div>