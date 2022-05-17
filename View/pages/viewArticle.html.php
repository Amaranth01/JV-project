<?php

use App\Controller\UserController;

?>

<div id="article">
    <h2 id="titleArticle"><?=$data['article']->getTitle()?></h2>
    <img src="/uploads/<?=$data['article']->getImage()?>" alt="Image de couverture de l'article" id="imgCover">
    <p id="contentArticle"><?=$data['article']->getContent()?></p>
    <p id="infoArticle">
        Article posté le <?=$data['article']->getDate()->format('d-m-Y')?> par
        <?=$data['article']->getUser()->getUsername()?>
    </p>

    <div id="comment">
        <h2>Commentaires : </h2>

        <?php if (UserController::userConnected()) {?>
            <form action="/index.php?c=comment&a=add-comment&id=<?=$data['article']->getId()?>" method="post" class="comment">
                <label for="comment">Laissez votre commentaire ici</label>
                <textarea name="content" id="comment" cols="60" rows="10"></textarea>
                <br>
                <input type="submit" name="submit" value="Envoyer" class="button">
            </form>

        <?php
            foreach ($data['comment'] as $comment) {?>
        <div id="commentContent">
            <img src="/assets/img/avatar/<?=$comment->getUser()->getImage()?>"
                 alt="Accès à l'espace utilisateur" id="userImage">
            <p class="userComment">Ecrit par : <?=$comment->getUser()->getUsername()?></p>
            <br><br>
            <p class="commentContent">"<?= $comment->getContent()?>"</p>
        </div>

        <?php
            }
        }
            else { ?>
                <p class="account">Il faut être connecté pour commenter un article.
                    <a href="/index.php?c=home&a=register" class="createAccount">Créer un compte</a>
                </p>
        <?php } ?>
    </div>

</div>