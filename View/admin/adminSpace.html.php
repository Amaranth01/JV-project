<h1>Espace d'administration</h1>

<div id="userStatus">
    <p>Changer le niveau d'accréditation</p>
<!--Chercher le nom du l'utilisateur pour mettre à jour le statut-->
    <form action="" method="post">
        <label for="username">Nom de l'utilisateur</label>
        <input type="text" name="username" id="username">

        <label for="role">Nouveau statut</label>
        <select name="role" id="role">
            <option value="user">Utilisateur</option>
            <option value="writer">Rédacteur</option>
            <option value="admin">Administrateur</option>
        </select>
        <br>
        <input type="submit" name="submit" value="Mettre à jour" class="button">
    </form>
</div>

<div id="delUser">
    <p>Supprimer un utilisateur</p>
<!--Rechercher le nom pour supprimer un utilisateur-->
    <form action="" method="post">
        <label for="username">Nom de l'utilisateur</label>
        <input type="text" name="username" id="username">
        <br>
        <input type="submit" name="submit" value="Mettre à jour" class="button">
    </form>
</div>