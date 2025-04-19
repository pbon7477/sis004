<div class="container-fluid">
    <div class="container is-fluid my-5 ">

        <div class="columns ">

            <!-- COLUMNA DERECHA -->
            <div class="column is-9 " style="border: 1px solid #7777;">


                <div class="columns">
                    <div class="column">
                        <h1 class="title">Usuarios</h1>
                        <h2 class="subtitle">Nuevo usuario</h2>

                    </div>
                </div>


                <form action="<?= APP_URL?>app/ajax/usuario_ajax.php" class="FormularioAjax" method="post" enctype="multipart/form-data" autocomplete="on">

                    <input type="hidden" name="modulo_usuario" value="registrar">

                    <div class="columns">
                        <!-- Nombre usuario -->
                        <div class="column is-6">
                            <div class="control">
                                <label for="usuario_nombre">Nombres:</label>
                                <input class="input is-small" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="usuario_nombre" id="usuario_nombre" maxlength="40" required>
                            </div>
                        </div>

                        <!-- Apellido usuario -->
                        <div class="column is-6">
                            <div class="control">
                                <label for="usuario_apellido">Apellidos:</label>
                                <input class="input is-small" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="usuario_apellido" id="usuario_apellido" required>
                            </div>
                        </div>
                    </div>

                    <div class="columns">

                        <div class="column is-6">
                            <div class="control">
                                <label for="usuario_usuario">Usuario:</label>
                                <input class="input is-small" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="usuario_usuario" id="usuario_usuario" maxlength="40" required>
                            </div>
                        </div>

                        <div class="column is-6">
                            <div class="control">
                                <label for="email">Email:</label>
                                <input class="input is-small" type="text" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" name="usuario_email" id="usuario_email" maxlength="30" required>
                            </div>
                        </div>

                    </div>

                    <div class="columns">
                        <div class="column is-4">
                            <div class="control">
                                <label for="usuario_clave_1">Password:</label>
                                <input class="input is-small" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.\-]{6,100}" id="usuario_clave_1" maxlength="100" required>
                            </div>
                        </div>

                        <div class="column is-4">
                            <div class="control">
                                <label for="usuario_clave_2">Confirmar password:</label>
                                <input class="input is-small" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.\-]{6,100}" id="usuario_clave_2" maxlength="100" required>
                            </div>
                        </div>


                    </div>

                    <div class="columns">
                        <div class="column is-4">
                            <div class="file has-name is-boxed">
                                <label for="usuario_foto" class="file-label">
                                    <input class="file-input is-small" type="file" name="usuario_foto" id="usuario_foto" accept=".jpg, .png, .jpeg">
                                    <span class="file-cta">
                                        <span class="file-label">Seleccione una foto</span>
                                    </span>
                                    <span class="file-name">jpg, jpeg, png, (max 5mb)</span>
                                </label>
                            </div>
                        </div>
                    </div>



                    <div class="columns">
                        <div class="column is-12">

                            <div class="is-flex is-justify-content-end" style="gap: 5px;">
                                <button class="button is-link is-light " type="reset">Limpiar</button>
                                <button class="button is-info" type="submit">Guardar</button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
            <!-- FIN COLUMNA DERECHA -->


            <!-- COLUMNA IZQUIERDA -->
            
            <div class="column is-3 " style="border: 0px solid #9999;">
                <h1 class="title has-text-warning">Quedamos en el minuto 00.00 min</h1>
                <p class="subtitle">Del video 36 → CRUD | USUARIOS → PARTE 3</p>
                <p>Subir foto del usuario al servidor</p>

            </div> 
           
            <!-- FIN COLUMNA IZQUIERDA -->

        </div>


    </div>
</div>



