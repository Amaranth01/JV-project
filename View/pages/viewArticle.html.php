<?php

use App\Model\Manager\ArticleManager;

 ?>

<div id="article">
    <h2 id="titleArticle"><?=ArticleManager::getArticle($data[0])->getTitle()?></h2>
    <p id="imgArticle"><?=ArticleManager::getArticle($data[0])->getImage()?></p>
    <p id="contentArticle"><?=ArticleManager::getArticle($data[0])->getContent()?></p>
    <p id="infoArticle">
        Article posté le XXXX par
        <?=ArticleManager::getArticle($data[0])->getUser()->getUsername()?>
    </p>
</div>
