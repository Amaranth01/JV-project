
<h1>Modifiez votre mot de passe</h1>

<form action="/index.php?c=user&a=forgot-password" method="post">

    <label for="password">Votre nouveau mot de passe</label>
    <input type="password" name="password" id="password" minlength="6" maxlength="50"  required>

    <label for="passwordR">Répéter votre nouveau mot de passe</label>
    <input type="password" name="passwordR" id="passwordR" minlength="6" maxlength="50" required >
    <br>
    <input type="submit" name="submit" value="Envoyer" class="button">

<!--    check if the id and token are presents in URL -->
    <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : 0 ?>">
    <input type="hidden" name="token" value="<?= isset($_GET['token']) ? $_GET['token'] : 0 ?>">
</form>