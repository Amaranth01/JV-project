<h1>Tous les commentaires</h1>

<table>
    <tr>
        <td>Contenu</td>
        <td>Auteur</td>
        <td>Article</td>
        <td>Edition</td>
        <td>Suppression</td>
    </tr>

    <?php
        use App\Model\Manager\CommentManager;

        foreach (CommentManager::findAllComment() as $comment ) {
            ?>
    <tr>
        <th><?=$comment->getContent()?></th>
        <th><?=$comment->getUser()->getUsername()?></th>
        <th><?=$comment->getArticle()->getTitle()?></th>
        <th><a href="/index.php?c=comment&a=update-comment&id=<?=$comment->getId()?>">Editer</a></th>
        <th><a href="/index.php?c=comment&a=delete-comment&id=<?=$comment->getId()?>">Supprimer</th>
    </tr>

     <?php
        }
    ?>

</table>