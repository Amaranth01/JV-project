<?php

use App\Controller\UserController;

    if (!UserController::userConnected()) {
        (new App\Controller\AbstractController)->render('home/index');
        exit();
    }
?>

<h1>Espace personnel</h1>

<div id="updateInformation" class="white">

    <form action="/index.php?c=user&a=user-image&id=<?=$_SESSION['user']->getId()?>" method="post" enctype="multipart/form-data">
        <label for="addImage">Ajouter une image de profil</label>
        <input type="file" name="img" id="img" accept=".jpg, .jpeg, .png" required>

        <p>Les formats supportés sont .jpg, .jpeg, .png</p>
        <input type="submit" name="submit" value="Mettre à jour" class="button">
    </form>

    <p>Changez vos informations</p>

    <form action="/index.php?c=user&a=update-username&id=<?=$_SESSION['user']->getId()?>" method="post">
        <label for="newUsername">Nouveau pseudo</label>
        <input type="text" name="newUsername" id="newUsername" minlength="6" required>
        <br>
        <input type="submit" name="submit" value="Mettre à jour" class="button">
    </form>

    <form action="/index.php?c=user&a=update-email&id=<?=$_SESSION['user']->getId()?>" method="post">
        <label for="newEmail">Nouvel email</label>
        <input type="text" name="newEmail" id="newEmail" required>
        <p>Un nouvel email vous sera envoyé</p>
        <input type="submit" name="submit" value="Mettre à jour" class="button">
    </form>

    <form action="/index.php?c=user&a=update-password&id=<?=$_SESSION['user']->getId()?>" method="post">
        <label for="newPassword">Nouveau mot de passe</label>
        <input type="password" name="newPassword" id="newPassword" required>

        <label for="newPasswordR">Répétez votre nouveau mot de passe</label>
        <input type="password" name="newPasswordR" id="newPasswordR" required>
        <br>
        <input type="submit" name="submit" value="Mettre à jour" class="button">
    </form>

    </form>
</div>

<div class="warning white" >
    <p>Suppression du compte : <a href="/index.php?c=user&a=delete">Supprimer votre compte</a></p>
</div>