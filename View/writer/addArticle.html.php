<h1>Ajouter un article</h1>

<form action="" method="post" enctype="multipart/form-data">

    <label for="image">Image de couverture : </label>
    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">

    <label for="title">Titre : </label>
    <input type="text" name="title" id="title" >


    <label for="editor">Contenu : </label>
    <textarea name="textarea" id="editor" cols="30" rows="10"></textarea>

    <div id="category">
        <p>Genre</p>
        <label for="RPG">RPG</label>
        <input type="checkbox" name="category" id="RPG" value="RPG">

        <label for="action">Action</label>
        <input type="checkbox" name="category" id="action" value="action">

        <label for="fps">FPS</label>
        <input type="checkbox" name="category" id="fps" value="FPS">

        <label for="mmo">MMO</label>
        <input type="checkbox" name="category" id="mmo" value="MMO">

        <label for="plateForm">Plate-forme</label>
        <input type="checkbox" name="category" id="plateForm" value="Plate-forme">

        <label for="moba">MOBA</label>
        <input type="checkbox" name="category" id="moba" value="MOBA">

        <label for="rts">RTS</label>
        <input type="checkbox" name="category" id="rts" value="RTS">

        <label for="bta">Beat Them All / Hack and Slash</label>
        <input type="checkbox" name="category" id="bta" value="Beat Them All / Hack and Slash">

        <label for="horror">Horreur</label>
        <input type="checkbox" name="category" id="horror" value="Horreur">

        <label for="sl">Souls-like</label>
        <input type="checkbox" name="category" id="sl" value="Souls-like">

        <label for="sport">Sport / Simulation</label>
        <input type="checkbox" name="category" id="sport" value="Sport / Simulation">

        <label for="other">Autres</label>
        <input type="checkbox" name="category" id="other" value="other">
    </div>

    <div id="platformGame">
        <p>Plateformes</p>

        <label for="news">News</label>
        <input type="checkbox" name="plateform" id="news" value="news">

        <label for="pc">PC</label>
        <input type="checkbox" name="plateform" id="pc" value="pc">

        <label for="ps">PlayStation</label>
        <input type="checkbox" name="plateform" id="ps" value="ps">

        <label for="xbox">XBox</label>
        <input type="checkbox" name="plateform" id="xbox" value="xbox">

        <label for="nintendo">Nintendo</label>
        <input type="checkbox" name="plateform" id="nintendo" value="Nintendo">
    </div>

    <input type="submit" name="submit" value="Envoyer" class="button">
</form>