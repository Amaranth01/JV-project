<?php

use App\Model\Manager\ArticleManager;
use App\Model\Manager\CommentManager;
use App\Model\Manager\UserManager;

?>

<div id="article">
    <h2 id="titleArticle"><?=ArticleManager::getArticle($data[0])->getTitle()?></h2>
    <img src="/uploads/<?=ArticleManager::getArticle($data[0])->getImage()?>" alt="Image de couverture de l'article" id="imgCover">
    <p id="contentArticle"><?=ArticleManager::getArticle($data[0])->getContent()?></p>
    <p id="infoArticle">
        Article posté le XXXX par
        <?=ArticleManager::getArticle($data[0])->getUser()->getUsername()?>
    </p>

    <div id="comment">
        <h2>Commentaires : </h2>

    <!--    Devoir être connecté pour écrire un commentaire-->
        <form action="/index.php?c=comment&a=add-comment&id=<?=ArticleManager::getArticle($data[0])->getId()?>" method="post" class="comment">
            <label for="comment">Laissez votre commentaire ici</label>
            <textarea name="content" id="comment" cols="60" rows="10"></textarea>
            <br>
            <input type="submit" name="submit" value="Envoyer" class="button">
        </form>

        <?php foreach (CommentManager::getCommentByArticleId($data[0]) as $comment) {?>
           <div>
               <img src="/assets/img/avatar/<?=UserManager::getUser($_SESSION['user']->getId())->getImage()?>"
               alt="Accès à l'espace utilisateur" id="userImage">
               <span class="userComment">Ecrit par : <?=$comment->getUser()->getUsername()?></span>
           </div>

            <p class="commentContent"><?= $comment->getContent()?></p>

    </div>
    <?php } ?>
</div>