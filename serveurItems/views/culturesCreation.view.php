<?php ob_start(); ?>

<form method="POST" action="<?= URL ?>back/cultures/creationValidation" enctype="multipart/form-data">
    <div class="form-group">
        <label for="nom_item">Nom</label>
        <input type="text" class="form-control" id="nom_item" name="nom_item">
    </div>
    <div class="form-group">
        <label for="description_famille">Description</label>
        <textarea class="form-control" id="description_culture" name="description_famille" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="image">Image :</label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <div class="form-group">
    <label for="image">Familles :</label>
        <select class="form-control" name="famille">
            <option></option>
            <?php foreach ($familles as $famille) : ?>
                <!-- valeur récupérée sur la partie serveur -->
                <option value="<?= $famille['id_famille'] ?>">
                <!-- contenu affiché -->
                <?= $famille['id_famille']  ?> - "<?= $famille['nom_ famille'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class='row no-gutters'>
        <div class="col-1"></div>
        <?php foreach($eaux as $eau) : ?>
            <div class="form-group form-check col-2">
            <input type="checkbox" class="form-check-input" name="eau-<? $idEau['id_eau']?>
            <label class="form-check-label" for="exampleCheck1"><?= $eau['besoin_besoin_eau'] ?>quantité d'eau ?</label>
            </div>
        <?php endforeach; ?>
        <div class="col-1"></div>
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
</form>

<?php
$content = ob_get_clean();
$titre = "Page de création d'une culture";
require "views/commons/template.php";

?>

