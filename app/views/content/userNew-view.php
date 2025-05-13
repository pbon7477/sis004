<div class="container-fluid">
    <div class="container  my-5 ">

        <div class="columns">
            <div class="column">
                <h1 class="title">Usuarios</h1>
                <h2 class="subtitle">Nuevo usuario</h2>
            </div>
        </div>

        <div class="columns ">

            <!-- COLUMNA DERECHA -->
            <div class="column is-9">





                <form action="<?= APP_URL ?>app/ajax/usuario_ajax.php" class="FormularioAjax" method="post" enctype="multipart/form-data" autocomplete="off">

                    <input type="hidden" name="modulo_usuario" value="registrar">

                    <div class="columns">
                        <!-- Nombre usuario -->
                        <div class="column is-6">
                            <div class="control">
                                <label for="usuario_nombre">Nombres: *</label>
                                <input class="input is-small" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="usuario_nombre" id="usuario_nombre" maxlength="40" required>
                            </div>
                        </div>

                        <!-- Apellido usuario -->
                        <div class="column is-6">
                            <div class="control">
                                <label for="usuario_apellido">Apellidos: *</label>
                                <input class="input is-small" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="usuario_apellido" id="usuario_apellido" required>
                            </div>
                        </div>
                    </div>

                    <div class="columns">

                        <!-- Usuario usuario -->
                        <div class="column is-6">
                            <div class="control">
                                <label for="usuario_usuario">Usuario: *</label>
                                <input class="input is-small" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="usuario_usuario" id="usuario_usuario" maxlength="40" required>
                            </div>
                        </div>

                        <!-- Usuario Emal -->
                        <div class="column is-6">
                            <div class="control">
                                <label for="email">Email: </label>
                                <input class="input is-small" type="text" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" name="usuario_email" id="usuario_email" maxlength="30">
                            </div>
                        </div>

                    </div>

                    <div class="columns">
                        <!-- Usuario Password 1 -->
                        <div class="column is-4">
                            <div class="control">
                                <label for="usuario_clave_1">Password: *</label>
                                <input class="input is-small" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.\-]{6,100}" id="usuario_clave_1" maxlength="100" required autocomplete="off">
                            </div>
                        </div>

                        <!-- Usuario Password 2 -->
                        <div class="column is-4">
                            <div class="control">
                                <label for="usuario_clave_2">Confirmar password: *</label>
                                <input class="input is-small" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.\-]{6,100}" id="usuario_clave_2" maxlength="100" required autocomplete="off">
                            </div>
                        </div>


                    </div>
                    <hr>

                    <div class="columns">
                        <!-- Usuario Foto -->
                        <div class="column is-5">
                            <div class="control">
                                <label for="usuario_foto" class="file-label">Seleccione una foto de perfil:</label>
                                <input class="button  is-small" type="file" name="usuario_foto" id="usuario_foto" value="" accept=".jpg, .png, .jpeg">
                            </div>
                            <small class="">Formato:.jpg, .jpeg, .png (Tamaño maximo: 5mb)</small>
                        </div>

                        <!-- Usuario Ouput foto -->
                        <div class="column is-2 is-flex is-justify-content-center is-align-items-center mt-3" style="border:1px solid #333; border-radius: 2px;">
                            <output class="is-rounded" id="imagePreview">
                                <small>Foto</small>
                            </output>

                        </div>


                    </div>



                    <div class="columns">
                        <div class="column is-12">

                            <div class="is-flex is-justify-content-end" style="gap: 5px;">
                                <button class="button is-link is-light " type="reset" id="limpiar">Limpiar</button>
                                <button class="button is-info" type="submit">Guardar</button>
                            </div>

                        </div>


                    </div>

                </form>
            </div>
            <!-- FIN COLUMNA DERECHA -->


            <!-- COLUMNA IZQUIERDA -->

            <div class="column is-3 m-1" >
              
            </div>

            <!-- FIN COLUMNA IZQUIERDA -->

        </div>


    </div>
</div>

<script src="<?= APP_URL; ?>app/views/js/mostrar_imagen_seleccionada.js"></script>