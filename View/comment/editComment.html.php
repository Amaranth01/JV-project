<?php

use App\Model\Manager\CommentManager;

?>

<h1>Edition des commentaires</h1>

<form action="/index.php?c=comment&a=edit-comment&id=<?=CommentManager::getComment($data[0])->getId() ?>" method="post">
    <label for="content">Editer le commentaire</label>
    <textarea name="content" id="content" cols="60" rows="20" required><?= CommentManager::getComment($data[0])->getContent() ?></textarea>
    <br>
    <input type="submit" name="submit" class="button" value="Mettre à jour">
</form>