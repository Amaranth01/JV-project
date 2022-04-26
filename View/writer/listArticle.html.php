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

foreach (ArticleManager::getArticleById() as $article) {
    ?>
    <tr>
        <th><?= $article->getTitle() ?></th>
        <th><?= $article->getResume() ?></th>
        <th><?= $article->getCategorie() ?></th>
        <th>Lien</th>
        <th>Lien</th>
    </tr>
<?php
}
?>
</table>