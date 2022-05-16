<h1>Mot de passe oublié</h1>

    <p>Un mail vous sera envoyé pour que vous puissiez réinitialiser votre nouveau mot de passe.</p>

    <form action="/index.php?c=user&a=check-email" method="post">
        <label for="email">Votre email</label>
        <input type="email" name="email" id="email">
        <br>
        <input type="submit" class="button" value="Envoyer">
    </form>