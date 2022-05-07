<?php
    use App\Controller\UserController;
    use App\Model\Manager\ArticleManager;

    if (!UserController::writerConnected() && !UserController::adminConnected()) {
        (new App\Controller\AbstractController)->render('home/index');
        exit();
    }
?>
<h1>Tous les articles publiés</h1>

<table>
    <tr>
        <td>Titre</td>
        <td>Résumé</td>
        <td>Edition</td>
        <td>Suppression</td>
    </tr>
<?php

    foreach ($data['article'] as $article) {
        ?>
        <tr>
            <th><?= $article->getTitle() ?></th>
            <th><?= $article->getResume() ?></th>
            <th><a href="/index.php?c=admin&a=update-article&id=<?=$article->getId()?>">Editer</a></th>
            <th><a href="/index.php?c=article&a=delete-article&id=<?=$article->getId()?>">Supprimer</a></th>
        </tr>
<?php
}
?>
</table>

<div class="styleNumber">
    <?php
    for ($i=0; $i< $data['page']; $i++) { ?>
        <a href="/index.php?c=admin&a=list-article&page=<?=$i+1?>" class="pagination"><?=$i+1?></a>
        <?php
    }
    ?>
</div>