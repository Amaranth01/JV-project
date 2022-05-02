<?php

use App\Controller\UserController;

    if (!UserController::userConnected()) {
        (new App\Controller\AbstractController)->render('home/index');
        exit();
    }
?>
<h1>Confirmation de suppression</h1>

<div class="warning">
    <p>Vous avez demandé la suppression de votre compte.
        <a href="/index.php?c=user&a=delete-user&id=<?= $_SESSION['user']->getId() ?>">Supprimer mon compte.</a>
    </p>
</div>