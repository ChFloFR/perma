<?php ob_start(); ?>
<!-- ob_start démarre la temporisation de sortie et aucune donnée n'est envoyée, mise en tampon, seul le header est envoyé -->
<form method="POST" action="<?= URL ?>back/connexion">
  <div class="form-group">
        <label for="login">Login</label>
        <input type="text" class="form-control" id="login" aria-describedby="loginHelp">

  </div>
  <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-primary">Valider</button>
</form>
<?php
$content = ob_get_clean();
$titre = "Login";
require "views/commons/template.php";

?>
<!-- tout ce qui se trouve dans ce code sera déversé dans le template au travers de $content qui sera ensuite utilisé dans la view common template -->
