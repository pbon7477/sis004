<?php

use app\Controllers\UserController;

$UserController = new UserController();
//capturamos el ID desde la 'url'
$id = explode("/", $_GET['views']);
$id = $UserController->limpiar_cadena($id[1]);


//Consultamos los datos del usuario
$datos_usuario = $UserController->seleccionar_datos('unico', 'usuarios', 'usuario_id', $id);

if ($datos_usuario->rowCount() == 1) :
    $datos = $datos_usuario->fetch();

?>


    <div class="container-fluid">
        <div class="container  mt-5">

            <div class="columns">
                <div class="column is-12">

                    <div class="is-flex is-justify-content-space-between">
                        <div>
                            <?php









                            if ($id == $_SESSION['id']):
                            ?>
                                <h1 class="title has-text-warning">Mi cuenta</h1>
                                <p class="subtitle">Actualizar cuenta</p>


                            <?php else : ?>
                                <h1 class="title has-text-warning">Usuarios</h1>
                                <p class="subtitle">Actualizar usuarios</p>

                            <?php endif;

                            ?>

                        </div>
                        <div class="">
                            <p><small><b>Nombre:</b> <?= $datos['usuario_nombre'] . ' ' . $datos['usuario_apellido'] ?></small></p>
                            <p><small><b>Creado:</b> <?= date('d-m-Y h:i:s A', strtotime($datos['usuario_creado'])); ?></small></p>
                            <p><small><b>Actualizado:</b> <?= date('d-m-Y h:i:s A', strtotime($datos['usuario_actualizado'])); ?></small></p>

                        </div>

                    </div>



                </div>
            </div>

            <div class="columns ">

                <!-- COLUMNA DERECHA -->
                <div class="column is-9">





                    <form action="<?= APP_URL ?>app/ajax/usuario_ajax.php" class="FormularioAjax" method="post"  autocomplete="off">

                        <input type="hidden" name="modulo_usuario" value="actualizar">
                        <input type="hidden" name="usuario_id" value="<?= $datos['usuario_id']; ?>">

                        <div class="columns">
                            <!-- Nombre usuario -->
                            <div class="column is-6">
                                <div class="control">
                                    <label class="label" for="usuario_nombre">Nombres: *</label>
                                    <input class="input is-small" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="usuario_nombre" id="usuario_nombre" value="<?= $datos['usuario_nombre']; ?>" maxlength="40" required>
                                </div>
                            </div>

                            <!-- Apellido usuario -->
                            <div class="column is-6">
                                <div class="control">
                                    <label class="label" for="usuario_apellido">Apellidos: *</label>
                                    <input class="input is-small" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="usuario_apellido" id="usuario_apellido" value="<?= $datos['usuario_apellido']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="columns">

                            <!-- Usuario usuario -->
                            <div class="column is-6">
                                <div class="control">
                                    <label class="label" for="usuario_usuario">Usuario: *</label>
                                    <input class="input is-small" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="usuario_usuario" id="usuario_usuario" maxlength="40" value="<?= $datos['usuario_usuario']; ?>" required>
                                </div>
                            </div>

                            <!-- Usuario Emal -->
                            <div class="column is-6">
                                <div class="control">
                                    <label class="label" for="email">Email: </label>
                                    <input class="input is-small" type="text" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" name="usuario_email" id="usuario_email" value="<?= $datos['usuario_email']; ?>" maxlength="30">
                                </div>
                            </div>

                        </div>

                        <p class="my-2">Si desea actualizar la contraseña de este usuario por favor llene los dos campos. Si no desea actualizar la contraseña, deje los campos vacíos.</p>
                        <div class="columns">
                            <!-- Usuario Password 1 -->
                            <div class="column is-4">
                                <div class="control">
                                    <label class="label" for="usuario_clave_1">Nuevo Password: </label>
                                    <input class="input is-small" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.\-]{6,100}" id="usuario_clave_1" maxlength="100" autocomplete="off">
                                </div>
                            </div>

                            <!-- Usuario Password 2 -->
                            <div class="column is-4">
                                <div class="control">
                                    <label class="label" for="usuario_clave_2">Confirmar password: </label>
                                    <input class="input is-small" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.\-]{6,100}" id="usuario_clave_2" maxlength="100" autocomplete="off">
                                </div>
                            </div>


                        </div>
                       


                        <br>
                        <hr>
                        <br>
                        <div class="columns">
                            <div class="column is-6">
                                <h2 class="is-size-3 px-1">Autorización</h2>
                                <p class="my-2">Para poder realizar la actualización de los datos del usuario por favor ingrese su USUARIO y CLAVE con la que inicio sesión.</p>

                            </div>

                            <div class="column is-6">

                                <div class="control">
                                    <label class="label">Usuario:</label>
                                    <input type="text" class="input is-small" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="administrador_usuario" id="administrador_usuario" autocomplete="off" required>
                                </div>

                                <div class="control">
                                    <label class="label">Contraseña:</label>
                                    <input type="password" class="input is-small" pattern="[a-zA-Z0-9$@.\-]{6,100}" name="administrador_clave" id="administrador_clave" autocomplete="off" required>
                                </div>
                            </div>
                        </div>



                        <div class="columns">
                            <div class="column is-12 mb-5">

                                <div class="is-flex is-justify-content-end" style="gap: 5px;">

                                    <a href="<?= APP_URL ?>dashboard/" class="button is-secondary" type="submit">Cancelar</a>
                                    <button class="button is-info" type="submit">Actualizar datos del usuario</button>
                                </div>

                            </div>


                        </div>

                    </form>




                </div>

                <!-- FIN COLUMNA DERECHA -->


                <!-- COLUMNA IZQUIERDA -->

                <div class="column is-3 " style="border: 0px solid #9999;">





                </div>

                <!-- FIN COLUMNA IZQUIERDA -->

            </div>


        </div>
    </div>

<?php else:
    include('app/views/inc/error_alert.php');
endif;   ?>


