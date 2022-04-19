<?php
    require __DIR__ . '/../../partials/header.php';

    //The parameter must be present the 1 means it is a success
    if(isset($_GET['success']) && intval($_GET['success']) === 1 ) { ?>
        <div class="success">Les données ont bien été envoyées.</div> <?php
    }
    //Parameter must be present 0 means there is an error
    elseif(isset($_GET['success']) && intval($_GET['success'] === 0)) { ?>
        <div class="error">Une erreur est survenue lors du traitement de vos données.</div> <?php
    }
    elseif(isset($_GET['success']) && intval($_GET['success']) === -1) { ?>
        <div class="error1">Votre mot de passe doit contenir au moins une lettre en majuscule et un chiffre</div> <?php
    }
?>
<!--A form to register-->
<div>
    <h2 class="subtitle">Inscrivez-vous</h2>

    <form action="/forms/form-register.php" method="post">

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
            <label for="password-register-repeat">Répétez votre mot de passe</label>
            <input type="password" name="password-repeat" id="password-register-repeat">
        </div>

        <div>
            <input type="submit" name="submit" value="Inscription" class="button">
        </div>

    </form>
</div>