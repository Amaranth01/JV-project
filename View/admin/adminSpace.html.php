<?php

use App\Model\Entity\Role;
use App\Model\Entity\User;
use App\Model\Manager\RoleManager;
use App\Model\Manager\UserManager;

?>
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
    <table>
        <tr>
            <td>Pseudo</td>
            <td>Email</td>
            <td>Modération</td>
        </tr>
        <?php
            foreach (UserManager::getAllUser() as $user) { ?>
                <tr>
                    <td><?= $user->getUsername() ?></td>
                    <td><?= $user->getEmail() ?></td>
                    <td>
                        <a href="/index.php?c=user&a=delete-user&id=<?= $user->getId() ?>">Supprimer</a>
                    </td>
                </tr>
        <?php
          }
        ?>
    </table>
</div>