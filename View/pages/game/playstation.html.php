<h1>L'univers PlayStation</h1>

<?php
foreach ($data as $article) {
    ?>
        <div>
            <div>
                <p><?= $article['article']->getTitle()?></p>
            </div>
            <div>
                <p><?= $article['article']->getcontent()?></p>
            </div>
        </div>
<?php
}