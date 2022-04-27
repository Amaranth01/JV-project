<h1>L'univers PlayStation</h1>

<?php

use App\Model\Manager\ArticleManager;

foreach (ArticleManager::findAllArticle() as $article) {
    ?>
        <div>
            <div>
                <a href="/index.php?c=home&a=view-article&id=<?=$article->getId()?>"><p><?= $article->getTitle()?></p></a>
            </div>
            <div>
                <p><?= $article->getResume()?></p>
            </div>
        </div>
<?php
}