<?php 
$selected = str_replace('/','',$_GET['views']);;

?>



<nav class="navbar is-dark nav-sticky">
  <div class="navbar-brand">
    <a class="navbar-item" href="<?= APP_URL;?>dashboard/">
      <img src="<?= APP_URL;?>/app/views/img/logo.png" alt="bulma" width="28" height="28">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu ">
    <div class="navbar-start">
      <a href="<?= APP_URL;?>dashboard/" class="navbar-item <?= ($selected == 'dashboard')?'is-selected' : ''; ?>">
        Dashboard
      </a>

      
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link btnSubMenu" data-target="subMenu">
          Usuarios
        </a>
        
        <div class="navbar-dropdown is-hidden" id="subMenu">
          <a href="<?= APP_URL;?>userNew/" class="navbar-item <?= ($selected == 'userNew')?'is-selected' : ''; ?>">Nuevo usuario</a>
          <hr class="navbar-divider">
          <a href="<?= APP_URL;?>userList/" class="navbar-item <?= ($selected == 'userList')?'is-selected' : ''; ?>">Lista de usuarios</a>
          <hr class="navbar-divider">
          <a href="<?= APP_URL;?>userSearch/" class="navbar-item <?= ($selected == 'userSearch')?'is-selected' : ''; ?>">Buscar usuario</a>

          
       
          
          
        </div>
      </div>
      

      
    </div>

    
    <div class="navbar-end">
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" id="btnSubMenu2"> <?= $_SESSION['usuario']?></a>

        <div class="navbar-dropdown is-hidden" id="subMenu2">
            <a href="<?= APP_URL  . 'userUpdate/' . $_SESSION['id'] . '/' ;?>"  class="navbar-item <?= ($selected == 'userUpdate')?'is-selected' : ''; ?>">Mi cuenta</a>
            <a href="<?= APP_URL . 'userPhoto/' . $_SESSION['id'] . '/' ;?>"   class="navbar-item <?= ($selected == 'userPhoto')?'is-selected' : ''; ?>"> Mi foto</a>
            <hr>
            <a href="<?= APP_URL;?>logOut/"  class="navbar-item <?= ($selected == 'logOut')?'is-selected' : ''; ?>" id="btn_exit">  Salir</a>
        </div>

      </div>
    </div>
    <!-- <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-primary">
            <strong>Sign up</strong>
          </a>
          <a class="button is-light">
            Log in
          </a>
        </div>
      </div>
    </div> -->
  </div>
</nav>


