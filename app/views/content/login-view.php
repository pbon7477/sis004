<div class="main-container">

    <form action="" class="box login" method="post" autocomplete="off">
        <h5 class="title is-size-5 has-text-centered is-uppercase">Login</h5>       

        <div class="field">
            <label for="login_usuario" class="label">Usuario</label>
            <div class="control">
                <input type="text" class="input" pattern="[a-zA-Z0-9]{4,20}" name="login_usuario" id="login_usuario" maxlength="20" required>
            </div>
        </div>

        <div class="field">
            <label for="login_clave" class="label">Clave</label>
            <div class="control">
                <input type="password" class="input" pattern="[a-zA-Z0-9$@.-]{7,100}" name="login_clave" id="login_clave" maxlength="100" required>
            </div>
        </div>

        <p class="has-text-centered mb-4 mt-3">
            <button type="submit" class="button is-info is-rounded">Iniciar sesion</button>
        </p>

    </form>

</div>