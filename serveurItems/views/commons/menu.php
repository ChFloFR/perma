<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- si Sécurite est à FALSE ... -->
      <?php if(!Securite::verifAccessSession()) : ?>

      <li class="nav-item">
        <a class="nav-link" href="<?= URL ?>back/login">Login</a>
      </li>
      <!-- Renvoit vers le reste (pas l'administration ) -->
      <?php else : ?>
      <li class="nav-item">
        <!-- lien d'administration accessible si l'utilisateur a les accès uniquement (grâce à la variable de session) -->
        <a class="nav-link" href="<?= URL ?>back/admin">Accueil</a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Familles
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= URL ?>back/familles/vue">vues des familles</a>
          <a class="dropdown-item" href="<?= URL ?>back/familles/création">Création de familles </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cultures
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= URL ?>back/cultures/vues">vues des cultures</a>
          <a class="dropdown-item" href="<?= URL ?>back/cultures/création">Création de cultures </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= URL ?>back/deconnexion">Déconnexion</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>