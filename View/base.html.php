<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JV Project</title>
    <link rel="stylesheet" href="/assets/css/styleMenu.css">
    <link rel="stylesheet" href="/assets/css/styleForm.css">
    <link rel="stylesheet" href="/assets/css/styleAdmin.css">
    <link rel="stylesheet" href="/assets/css/styleUserSpace.css">
    <link rel="stylesheet" href="/assets/css/styleError.css">
    <link rel="stylesheet" href="/assets/css/styleArticle.css">
    <link rel="stylesheet" href="/assets/css/darkMode.css">
</head>
<body>
<?php

// Handling error messages.
use App\Controller\UserController;
use App\Model\Manager\UserManager;

if(isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
     ?>
        <div class="message error">
            <button name="button" class="close">X</button>
            <?= $errors ?>
        </div> <?php
}

// Handling success messages.
if(isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
    ?>
    <div class="message success">
        <button name="button" class="close">X</button>
        <?= $success ?>
    </div> <?php
}
var_dump($_SESSION['user']);
?>
<!--First menu-->
<div>
    <nav >
        <ul class="list" id="second-nav">
            <li><a href="/index.php?c=home&a=pc">PC</a></li>
            <li><a href="/index.php?c=home&a=playstation">PlayStation</a></li>
            <li><a href="/index.php?c=home&a=nintendo">Nintendo</a></li>
            <li><a href="/index.php?c=home&a=xbox">Xbox</a></li>
        </ul>
        <?php if (UserController::userConnected()) {?>
        <a href="/index.php?c=home&a=user-space">
            <img src="/assets/img/avatar/<?=UserManager::getUser($_SESSION['user']->getId())->getImage()?>" alt="Accès à l'espace utilisateur" id="userSpace">
        </a>
        <?php
            }
        ?>
    </nav>
</div>

<!--Second menu-->
<div>
    <nav id="firstNav" >
        <a href="/index.php?c=home&a=index">
            <img src="/assets/img/Capture%20d’écran%202022-02-15%20112818.png" alt="Le logo du site" id="logo">
        </a>
        <ul class="list">
            <li>Jeux
                <ul class="little">
                    <li><a href="/index.php?c=home&a=news">News</a></li>
                    <li><a href="/index.php?c=home&a=tests">Tests</a></li>
                    <li><a href="/index.php?c=home&a=help">Soluces</a></li>
                    <li><a href="/index.php?c=home&a=nextgame">Calendrier des sorties</a></li>
                </ul>
            </li>
            <li><a href="/index.php?c=home&a=series">Séries et films</a></li>
            <input type="search" placeholder="Recherche">
            <li><a href="/index.php?c=home&a=tchat">Tchat</a></li>
            <li><a href="/index.php?c=home&a=poll">Sondages</a></li>
            <button class="darkMode"><i class="fas fa-adjust"></i></button>


            <?php if (UserController::userConnected()) {?>
            <li><a href="/index.php?c=logout&a=logout">Déconnexion</a></li>
                <?php
            }
            else { ?>
                <li><a href="/index.php?c=home&a=login">Connexion/Inscription</a></li>
            <?php }
                if(UserController::writerConnected() || UserController::adminConnected()) { ?>
                    <li><a href="/index.php?c=admin&a=index">Espace des rédacteurs</a></li>
            <?php
            }
            ?>

        </ul>
    </nav>
</div>

<main class="container">
    <?=$html?>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/25d98733ec.js"></script>

<script src="/assets/js/app.js"></script>
<script src="/assets/js/theme.js"></script>
<script src="/assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="/assets/js/wysiwyg.js"></script>
<script src="/assets/js/button.js"></script>

</body>
</html>