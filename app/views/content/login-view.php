<div class="main-container">

    <form action="" class="box login" method="post" autocomplete="off">
        <h5 class="title is-size-5 has-text-centered is-uppercase">Login</h5>  
        <div class="has-text-centered">
            <img src="<?= APP_URL;?>app/views/img/logo.png" alt="" width="50">
        </div>     

        <div class="field">
            <label for="login_usuario" class="label">Usuario</label>
            <div class="control">
                <input type="text" class="input" pattern="[a-zA-Z0-9]{4,20}" name="login_usuario" id="login_usuario" maxlength="20" required>
            </div>
        </div>

        <div class="field">
            <label for="login_clave" class="label">Clave</label>
            <div class="control">
                <input type="password" class="input" pattern="[a-zA-Z0-9$@.\-]{6,100}" name="login_clave" id="login_clave" maxlength="100" autocomplete="off" required>
            </div>
        </div>

        <p class="has-text-centered mb-4 mt-5">
            <button type="submit" class="button is-info  ">Iniciar sesion</button>
            
        </p>

    </form>

</div>




<?php 
//LOGIN CONTROLLER
if(isset($_POST['login_usuario']) && isset( $_POST['login_clave'] ) ){
    $LoginController->iniciar_session_controlador();
}

?>