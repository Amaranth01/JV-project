<h1>Modifiez votre mot de passe</h1>

<form action="/index.php?c=user&a=forgot-password" method="post">

    <label for="password">Votre nouveau mot de passe</label>
    <input type="password" name="password" id="password">

    <label for="passwordR">Répéter votre nouveau mot de passe</label>
    <input type="password" name="passwordR" id="passwordR">
    <br>
    <input type="submit" name="submit" value="Envoyer" class="button">

</form>