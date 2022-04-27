<h1>Toutes les news</h1>

<?php
foreach ($data as $article) {
    ?>
<div id="content">
    <p class="artTitle"><?= $article['jvp_article']->getTitle()?></p>
    <div class="article">

        <div>
            <p class="img"><img src="/asset/uploads/<?= $article['jvp_article']->getImage()?>" alt=""></p>
        </div>
        <p class="textContent"><?=$article['jvp_article']->getContent() ?></p>
    </div>
</div>
<?php
    }
?>