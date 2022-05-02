<?php

    use App\Controller\UserController;
    use App\Model\Manager\UserManager;

    if (!UserController::adminConnected()) {
        (new App\Controller\AbstractController)->render('home/index');
        exit();
    }

?>
<h1>Espace d'administration</h1>

<div id="userStatus">
    <p>Changer le niveau d'accréditation</p>
<!--Chercher le nom du l'utilisateur pour mettre à jour le statut-->
    <form action="/index.php?c=user&a=update-user-role" method="post">
        <label for="username">Nom de l'utilisateur</label>
        <input type="text" name="username" id="username"">

        <label for="role">Nouveau statut</label>
        <select name="role" id="role">
            <option value="1">Utilisateur</option>
            <option value="2">Rédacteur</option>
            <option value="3">Administrateur</option>
        </select>
        <br>
        <input type="submit" name="submit" value="Mettre à jour" class="button">
    </form>
</div>

<div id="delUser">
    <table>
        <tr>
            <td>Pseudo</td>
            <td>Email</td>
            <td>Role</td>
            <td>Modération</td>
        </tr>
        <?php
            foreach (UserManager::getAllUser() as $user) { ?>
                <tr>
                    <td><?= $user->getUsername() ?></td>
                    <td><?= $user->getEmail() ?></td>
                    <td><?= $user->getRole()->getRoleName()?></td>
                    <td>
                        <a href="/index.php?c=user&a=delete-user&id=<?= $user->getId() ?>">Supprimer</a>
                    </td>
                </tr>
        <?php
          }
        ?>
    </table>
</div>