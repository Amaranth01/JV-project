<h1>Toutes les news</h1>
<?php

use App\Model\Manager\ArticleManager;

foreach ($data['article']as $article) {
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
    for ($i=0; $i< $data['page']; $i++) { ?>
        <a href="/index.php?c=home&a=news&page=<?=$i+1?>" class="pagination"><?=$i+1?></a>
<?php    
}
?>

