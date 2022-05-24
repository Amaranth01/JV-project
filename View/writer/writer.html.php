<?php

use App\Controller\AbstractController;
use App\Controller\UserController;
    use App\Model\Manager\ArticleManager;
    use App\Model\Manager\CommentManager;

    if (!UserController::writerConnected() && !UserController::adminConnected()) {
        (new App\Controller\AbstractController)->render('home/index');
        exit();
    }

?>
<h1>L'espace de rédaction</h1>
    <?php
    if(UserController::userConnected() && UserController::adminConnected()) {?>
        <div id="admin">
            <a href="/index.php?c=admin&a=admin-space">
                <img src="/assets/img/adminSpace.png" alt="Espace administration">
                <br>
                Espace d'administration
            </a>
        </div>
        <?php
    }
    ?>
<h2>Les derniers articles</h2>

<div class="content">

        <div class="left writerLeft">
            <?php

            foreach (ArticleManager::findAllArticle(4) as $article) {
            ?>
            <article class="contentResumeArticleIndex">
                <a href="/index.php?c=home&a=view-article&id=<?= $article->getId() ?>">
                    <div>
                        <img src="/uploads/<?= $article->getImage() ?>" alt="Image de couverture de l'article"
                             class="artImage">
                    </div>
                    <div>
                        <p class="artTitle"><?= $article->getTitle() ?></p>
                    </div>
                </a>
                <p class="artResume"><?= $article->getResume() ?></p>
            </article>

        <?php
        }
        ?>
        </div>

        <div>
            <p class="addArticle">
                <a href="/index.php?c=admin&a=add-article" class="white">
                    <span id="more">+</span>
                    <br>
                    Ajouter un article
                </a>
            </p>
        </div>
        <div>
            <p class="addArticle">
                <a href="/index.php?c=admin&a=list-article" class="white">
                    <img src="assets/img/allArt.png" alt="image de copie" id="allArtImg">
                    <br>
                    Tous les articles
                </a>
            </p>
        </div>
</div>

<h2 class="titleCommentWriter">Les derniers commentaires</h2>
    <div class="content contentCommentWriter">

            <div class="leftWriter">
                <?php

                foreach (CommentManager::findAllComment(5) as $comment) {
                    ?>
                    <div class="contentResumeArticleIndex">
                        <p class="artTitle">Ecrit par : <?= $comment->getUser()->getUsername() ?></p>
                        <p class="artResume"><?= $comment->getContent() ?></p>
                    </div>
                    <?php
                }
                ?>


            </div>
            <div>
                <p class="addArticle">
                    <a href="/index.php?c=comment&a=all-comment" class="white">
                        <img src="assets/img/allCom.png" alt="image de bulle de dialogue" id="allComImg">
                        <br>
                        Tous les commentaires
                    </a>
                </p>
            </div>
    </div>
