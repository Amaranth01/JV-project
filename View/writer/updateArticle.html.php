
<h1>Editer un article</h1>

<?php

use App\Model\Manager\ArticleManager;

?>

<form action="/index.php?c=article&a=update-article&id=<?=ArticleManager::getArticle($data[0])->getId() ?>" method="post" id="form">

    <label for="title">Mise à jour du titre</label>
    <input type="text" name="title" value="<?= ArticleManager::getArticle($data[0])->getTitle() ?>" id="title">

    <label for="editor">Mise à jour de l'article</label>
    <textarea name="content" id="editor" cols="30" rows="20"><?= ArticleManager::getArticle($data[0])->getContent() ?></textarea>
    <br>
    <input type="submit" name="submit" class="button">
</form>