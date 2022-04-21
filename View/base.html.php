<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JV Project</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php

// Handling error messages.
if(isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);

    foreach($errors as $error) { ?>
        <div class="message error">
            <button name="button" class="close">X</button>
            <?= $error ?>
        </div> <?php
    }
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
?>

<!--First menu-->
<div>
    <nav id="firstNav" >
        <img src="/assets/img/Capture%20d’écran%202022-02-15%20112818.png" alt="Le logo du site">
        <ul class="list">
            <li><a href="/public/pages/game.php">Jeux</a>
                <ul class="little">
                    <li><a href="">News</a></li>
                    <li><a href="">Tests</a></li>
                    <li><a href="">Soluce</a></li>
                    <li><a href="">Calendrier des sorties</a></li>
                </ul>
            </li>
            <li><a href="">Série et film</a></li>
            <input type="search" placeholder="Recherche">
            <li><a href="">Tchat</a></li>
            <li><a href="">Sondages</a></li>
            <button class="dark-mode"><i class="fas fa-adjust"></i></button>
            <li><a href="">Connexion</a></li>
        </ul>
    </nav>
</div>

<!--Second menu-->
<div>
    <nav >
        <ul class="list" id="second-nav">
            <li><a href="">PC</a></li>
            <li><a href="">PlayStation</a></li>
            <li><a href="">Nintendo</a></li>
            <li><a href="">Xbox</a></li>
        </ul>
    </nav>
</div>

<main class="container">
    <?=$html?>
</main>

<script src="/asset/js/app.js"></script>
<script src="/asset/js/theme.js"></script>
</body>
</html>