<?php ob_start(); ?>

<form method="POST" action="<?= URL ?>back/cultures/modificationValidation" enctype="multipart/form-data">
<!-- id_item récupéré ds $_POST du cultures.controller -->
    <input type='hidden' name='id_item' value="<?= $culture['id_item']; ?>" />
    <div class="form-group">
        <label for="nom_item">Nom</label>
        <input type="text" class="form-control" id="nom_item" name="nom_item" value="<?= $culture["nom_item"]?>"
    </div>
    <div class="form-group">
        <label for="description_item">Description</label>
        <textarea class="form-control" id="description_culture" name="description_culture" rows="3"><?= $culture["description_item"]?></textarea>
    </div>
    <div class="form-group">
        <img src="<?= URL ?>public/images/<?= $culture['img_item']?>" style="width:50px;"/>
        <label for="image">Image :</label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <div class="form-group">
    <label for="image">Familles :</label>
        <select class="form-control" name="famille">
            <option></option>
            <?php foreach ($familles as $famille) : ?>
                <!-- valeur récupérée sur la partie serveur -->
                <option value="<?= $famille['id_famille'] ?>"
                
                <?php if($famille['id_famille']=== $lignesCulture[0]['id_famille']) echo "selected"; ?>
                >
                <!-- on a vérifié si l'id de la famille que l'on parcours correspond à la famille de culture actuellement modifiée. Si oui "selected" actionné-->
                <!-- contenu affiché -->
                <?= $famille['id_famille']  ?> - "<?= $culture['nom_famille'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class='row no-gutters'>
        <div class="col-1"></div>
        <?php foreach($eaux as $eau) : ?>
            <div class="form-group form-check col-2">
            <input type="checkbox" class="form-check-input" name="eau-<? $idEau['id_eau']?>">
                <?php if(in_array($eau['id_eau'], $tabEau))
                echo "checked";
                ?>
            <label class="form-check-label" for="exampleCheck1"><?= $eau['besoin_besoin_eau'] ?>quantité d'eau ?</label>
            </div>
        <?php endforeach; ?>
        <div class="col-1"></div>
    </div>
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>

<?php
$content = ob_get_clean();
$titre = "Page de modification d'une culture : ".$culture[0]['nom_item'];
require "views/commons/template.php";

?>

