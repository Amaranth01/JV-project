<h1>Toutes les news</h1>
<?php

use App\Model\Manager\ArticleManager;

foreach (ArticleManager::findAllArticle(0) as $article) {
    ?>
    <div class="contentResumeArticleIndex center">
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