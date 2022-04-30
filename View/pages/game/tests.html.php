<h1>Nos tests</h1>

<?php

use App\Model\Manager\ArticleManager;

foreach (ArticleManager::getArticleBySectionId(2) as $article) {
    ?>
    <div class="contentResumeArticle">
        <a href="/index.php?c=home&a=view-article&id=<?= $article->getId() ?>">
            <div>
                <img src="/uploads/<?= $article->getImage() ?>" alt="Image de couverture de l'article" class="artImage">

            </div>
            <div>
                <p class="artTitle"><?= $article->getTitle() ?></p></a>
        <p class="artResume"><?= $article->getResume() ?></p>
    </div>
    </div>

    <?php
}