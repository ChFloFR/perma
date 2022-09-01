<?php ob_start(); ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Culture</th>
      <th scope="col">Description</th>
      <th scope="col" colspan="2">Actions</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <!-- on va parcourir chaque item culture -->
      <?php foreach ($cultures as $culture) : ?>
        <td class="align_middle"><?= $culture['id_item'] ?></td>
        <td>
            <!--insertion de l'image  -->
          <img src="<?= URL ?>public/images/<?= $culture['img_item']?>" style="width:50px"/>
        </td>
        <!-- insertion du nom de la culture, sa description et sa famille -->
        <td class="align_middle"><?= $culture['nom_item'] ?></td>
        <td class="align_middle"><?= $culture['description_item'] ?></td>
        <td class="align_middle"><?= $culture['id_famille_item'] ?></td>
        <td class="align_middle">
          <a href="<?= URL ?>back/cultures/modification/<? $culture['item_culture'] ?>"class=" btn btn-warning">Modifier</a>
        </td>
            <td class="align_middle">
              <textarea name='description_item' class='form-control' rows="3"><?= $culture['description_item'] ?>
            </textarea>
            </td>
            <td colspan="2">            
              <input type="hidden" name="id_item" value="<?= $culture['id_item'] ?>" />
              <button class="btn btn-primary" type="submit">Créer</button>
            </td>
          </form>
        </td>
    <td>+
      <form method="post" action="<?= URL ?>back/validationSuppression" onSubmit="'Voulez-vous vraiment supprimer cette culture ?">             
        <input type="hidden" name="id_item" value="<?= $culture['id_item'] ?>"/>
        <button class="btn btn-danger">Supprimer</button>
      </form>
    </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php
$content = ob_get_clean();

$titre = "les cultures";
require "views/commons/template.php";

?>