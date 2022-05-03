<div class="content">
    <div class="left">
        <h2>Nos derniers articles</h2>
            <?php

            use App\Model\Manager\ArticleManager;

            foreach (ArticleManager::findAllArticle(4) as $article) {
                    ?>
            <div class="contentResumeArticleIndex">
                <a href="/index.php?c=home&a=view-article&id=<?= $article->getId() ?>">
                    <div>
                        <img src="/uploads/<?= $article->getImage() ?>" alt="Image de couverture de l'article"
                             class="artImage">
                    </div>
                    <div>
                        <p class="artTitle"><?= $article->getTitle() ?></p>
                </a>
                <p class="artResume"><?= $article->getResume() ?></p>
            </div>
    </div>
    <?php
            }
        ?>
    </div>

    <div class="right">
        <h2>Nos derniers tests</h2>
            <?php
                foreach (ArticleManager::getArticleBySectionId(2) as $article) {
                    ?>
        <div class="contentResumeArticleIndex">
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
            ?>

    </div>
</div>

<div class="contentDown">
    <div class="left">
        <h2>Nos dernières séries</h2>
            <?php
               foreach (ArticleManager::getArticleBySectionId(5) as $article) {
                   ?>
                <div class="contentResumeArticleIndex">
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
            ?>
    </div>

    <div class="right">
        <h2>Les jeux les plus attendus</h2>
        <br>
        <h3>Par vous :</h3>
        <h3>Par la rédaction :</h3>
    </div>
</div>

