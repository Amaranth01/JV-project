<h1>Toutes les news</h1>
<?php

use App\Model\Manager\ArticleManager;

foreach (ArticleManager::findAllArticle() as $article) {
    ?>
        <div>
            <div>
                <a href="/index.php?c=home&a=view-article&id=<?=$article->getId()?>">
                    <img src="/uploads/<?=$article->getImage()?>" alt="Image de couverture de l'article" id="artImage">
                    <p><?= $article->getTitle()?></p></a>
            </div>
            <div>
                <p><?= $article->getResume()?></p>
            </div>
        </div>
<?php
}