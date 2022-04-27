<h1>Tous les articles publiés</h1>

<table>
    <tr>
        <td>Titre</td>
        <td>Auteur</td>
        <td>Catégorie</td>
        <td>Edition</td>
        <td>Suppression</td>
    </tr>
<?php

use App\Model\Manager\ArticleManager;

foreach (ArticleManager::findAllArticle() as $article) {
    ?>
    <tr>
        <th><?= $article->getTitle() ?></th>
        <th><?= $article->getResume() ?></th>
        <th><?= $article->getCategorie() ?></th>
        <th><a href="">Editer</a></th>
        <th><a href="">Supprimer</a></th>
    </tr>
<?php
}
?>
</table>