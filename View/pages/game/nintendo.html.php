<h1>L'univers Nintendo</h1>

<?php

foreach ($data as $article) {
    ?>
    <div>
        <div>
            <a href="/index.php?c=home&a=view-article&id=<?=$article->getId()?>"><p><?= $article['article']->getTitle()?></p></a>
        </div>
        <div>
            <p><?= $article->getResume()?></p>
        </div>
    </div>
    <?php
}