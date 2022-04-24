<h1>Espace personnel</h1>

<div id="profilePicture">

    <form action="" method="post" enctype="multipart/form-data">
        <label for="addImage">Ajouter une image de profil</label>
        <input type="file" name="image" id="addImage" accept=".jpg, .jpeg, .png">
    </form>
    <p>Les formats supportés sont .jpg, .jpeg, .png</p>
</div>

<div id="updateInformation">
    <p>Changez vos informations</p>

    <form action="" method="post">
        <label for="newUsername">Nouveau pseudo</label>
        <input type="text" name="newUsername" id="newUsername">

        <label for="newEmail">Nouvel email</label>
        <input type="text" name="newEmail" id="newEmail">
        <p>Un nouvel email vous sera envoyé</p>

        <label for="newPassword">Nouveau mot de passe</label>
        <input type="text" name="newPassword" id="newPassword">

        <label for="newPasswordR">Répétez votre nouveau mot de passe</label>
        <input type="password" name="newPasswordR" id="newPasswordR">
        <br>
        <input type="submit" name="submit" value="mettre à jour" class="button">
    </form>
</div>

<div class="warning">
    <p>Suppression du compte : <a href="/index.php?c=user&a=delete">Supprimer votre compte</a></p>
</div>