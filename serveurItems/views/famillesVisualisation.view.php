<?php ob_start(); ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Familles</th>
      <th scope="col">Description</th>
      <th scope="col" colspan="2">Actions</th>
    </tr>
  </thead>
  <tbody>
    <!-- on va parcourir chaque famille -->
    <?php foreach($familles as $famille) : ?>
      <!-- si id_famille posté est différent d'id_famille -->
      <?php ? if(empty($_POST['id_famille']) || $_POST['id_famille'] !== $famille['id_famille']) : ?>
        <tr>
            <td><?= $famille['famille_id'] ?></td>
            <td><?= $famille['nom_famille'] ?></td>
            <td><?= $famille['famille_description'] ?></td>
            <td><?= $famille['famille_famille'] ?></td>
            <td>
              <form method="post" action="">
              <input type="hidden" name="id_famille" value="<?= $famille['id_famille'] ?> />
                  <button class="btn btn-warning" type="submit">Modifier</button>

              </form>
            </td>
            <td>
              <!-- suppression d'une famille -->
                  <form method='post' action="<?= URL ?>.back/familles/validationSuppression" onSubmit= "return('Voulez-vous supprimer cette famille ?')";>
                  <input type="hidden" name="id_famille" value="<?= $famille['id_famille'] ?>" />
                  <button class="btn btn-danger" type="submit">Supprimer</button>
                  </form>
            </td>  
          </tr>
          <?php else: ?>
            <!-- Route pour la nouvelle page de modification -->
            <form method="post" action="<?= URL ?>back/validationModification">
              <tr>
                <td><?= $famille['famille_id'] ?></td>
                <td><input type="text" name="nom_famille" class='form-control' value="$famille['nom_famille'] ?>"/>
                <td><textarea name='famille_description' class='form-control' rows="3"><?= $famille['famille_description'] ?></textarea></td>
                <td colspan="2">
                  <input type="hidden" name="id_famille" value="<?= $famille['id_famille'] ?>"/>
                  <button class="btn btn-primary" type="submit">Valider</button>
                </td>
              </tr>
            </form>
        <?php endif; ?>
    <?php endforeach; ?>
  </tbody>
</table>
<?php
$content = ob_get_clean();

$titre = "les familles";
require "views/commons/template.php";

?>

