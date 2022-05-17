<?php

    use App\Controller\UserController;
    use App\Model\Manager\ArticleManager;

    if (!UserController::writerConnected() && !UserController::adminConnected()) {
        (new App\Controller\AbstractController)->render('home/index');
        exit();
    }
?>
<h1>Editer un article</h1>

<form action="/index.php?c=article&a=edit-article&id=<?=$data['article']->getId() ?>" method="post" id="form">

    <label for="title">Mise à jour du titre</label>
    <input type="text" name="title" value="<?= $data['article']->getTitle() ?>" id="title">

    <label for="editor">Mise à jour de l'article</label>
    <textarea name="content" id="editor" cols="30" rows="20"><?= $data['article']->getContent() ?></textarea>
    <br>
    <input type="submit" name="submit" class="button">
</form>