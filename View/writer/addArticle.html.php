<h1>Ajouter un article</h1>

<form action="/index.php?c=article&a=add-article" method="post" enctype="multipart/form-data">

    <label for="img">Image de couverture : </label>
    <input type="file" name="img" id="img" accept=".jpg, .jpeg, .png">

    <label for="title">Titre : </label>
    <input type="text" name="title" id="title" >

    <label for="editor">Contenu : </label>
    <textarea name="content" id="editor" cols="30" rows="10" ></textarea>

    <div id="category">
        <p>Type de jeu</p>
        <?php
        /**
         * @var Category $category
         */

        use App\Model\Entity\Category;
        use App\Model\Entity\Platform;

        foreach ($data['categories'] as $category) { ?>
                <label for="cat_<?=$category->getId() ?>"><?=$category->getCategoryName() ?></label>
                <input type="checkbox" name="cat_<?=$category->getId() ?>" value="<?=$category->getId() ?>">
            <?php
            }
        ?>
    </div>

    <div id="platform">
        <p>Plateformes</p>
<?php
        /**
         * @var Platform $platform
         */

        foreach ($data['platforms'] as $platform) { ?>
                <label for="plat_<?=$platform->getId()?>"><?=$platform->getPlatformName()?></label>
                <input type="checkbox" name="plat_<?=$platform->getId()?>" value="<?=$platform->getId()?>">
            <?php
            }
        ?>
<!--        <label for="pc">PC</label>-->
<!--        <input type="checkbox" name="platform" id="pc" value="pc">-->
<!---->
<!--        <label for="playstation">PlayStation</label>-->
<!--        <input type="checkbox" name="platform" id="playstation" value="playstation">-->
<!---->
<!--        <label for="xbox">Xbox</label>-->
<!--        <input type="checkbox" name="platform" id="xbox" value="xbox">-->
<!---->
<!--        <label for="nintendo">Nintendo</label>-->
<!--        <input type="checkbox" name="platform" id="nintendo" value="Nintendo">-->
<!---->
<!--        <label for="others">Autres</label>-->
<!--        <input type="checkbox" name="platform" id="others" value="autres">-->
    </div>

    <div id="section">
        <p>Sections</p>

        <label for="news">News</label>
        <input type="checkbox" name="section" id="news" value="News">

        <label for="test">Test</label>
        <input type="checkbox" name="section" id="test" value="test">

        <label for="answer">Soluce</label>
        <input type="checkbox" name="section" id="answer" value="soluce">

        <label for="calendar">Calendrier</label>
        <input type="checkbox" name="section" id="calendar" value="test">

        <label for="series">Séries & film</label>
        <input type="checkbox" name="section" id="series" value="series">
    </div>

    <div id="resume">
        <label for="resume">Résumé de l'article</label>
        <textarea name="resume" id="resume" cols="60" rows="10"></textarea>
    </div>

    <input type="submit" name="submit" value="Envoyer" class="button">
</form>