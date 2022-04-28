<h1>L'univers Xbox</h1>

<?php

use App\Model\Manager\ArticleManager;
use App\Model\Manager\CategoryManager;

foreach (ArticleManager::articlePlatform(4) as $article) {
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