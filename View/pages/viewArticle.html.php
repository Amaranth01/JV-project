<?php

use App\Model\Manager\ArticleManager;
use App\Model\Manager\CommentManager;

?>

<div id="article">
    <h2 id="titleArticle"><?=ArticleManager::getArticle($data[0])->getTitle()?></h2>
    <p id="imgArticle"><?=ArticleManager::getArticle($data[0])->getImage()?></p>
    <p id="contentArticle"><?=ArticleManager::getArticle($data[0])->getContent()?></p>
    <p id="infoArticle">
        Article posté le XXXX par
        <?=ArticleManager::getArticle($data[0])->getUser()->getUsername()?>
    </p>


    <div id="comment">
        <h2>Commentaires : </h2>

    <!--    Devoir être connecté pour écrire un commentaire-->
        <form action="/index.php?c=comment&a=add-comment" method="post" class="comment">
            <label for="comment">Laissez votre commentaire ici</label>
            <textarea name="comment" id="comment" cols="60" rows="10"></textarea>
            <br>
            <input type="submit" name="submit" value="Envoyer" class="button">
        </form>

        <?php foreach (CommentManager::findAllComment() as $comment) {?>
            <p id="userComment">Ecrit par : <?=$comment->getUser()->getUsername() ?><p>
            <p id="commentContent"><?= $comment->getContent()?></p>

    </div>
    <?php } ?>
</div>