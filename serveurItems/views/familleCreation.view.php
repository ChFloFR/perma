<?php ob_start(); ?>

<form method="POST" action="<?= URL ?>back/familles/creationValidation">
    <div class="form-group">
        <label for="nom_famille">Nom</label>
        <input type="text" class="form-control" id="nom_famille" name="nom_famille">
    </div>
    <div class="form-group">
        <label for="description_famille">Description</label>
        <textarea class="form-control" id="description_famille" name="description_famille" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
</form>

<?php
$content = ob_get_clean();
$titre = "Page de création d'une famille";
require "views/commons/template.php";

?>

