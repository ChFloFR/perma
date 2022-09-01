<?php ob_start(); ?>

<?php
$content = ob_get_clean();
$titre = "Page d'administration du site";
require "views/commons/template.php";

?>

