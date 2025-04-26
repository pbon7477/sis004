<?php

use app\Controllers\UserController;

$url = explode('/', $_GET['views']);
$id = $LoginController->limpiar_cadena($url[1]);

$UserController = new UserController();

$datos_usuario = $UserController->seleccionar_datos('unico', 'usuarios', 'usuario_id', $id);

$existe = false;

if ($datos_usuario->rowCount() == 1) {
    $datos_usuario = $datos_usuario->fetch(PDO::FETCH_ASSOC);

    $id = $datos_usuario['usuario_id'];
    $existe = true;
} else {
    echo 'No existe el usuario';
    $existe = false;
}

?>



<div class="container-fluid">

    <div class="container is-fluid my-5 ">

        <div class="columns">

            <?php if ($id == $_SESSION['id']) :  ?>

                <div class="column">
                    <h1 class="title">Mi foto de perfil</h1>
                    <h2 class="subtitle">Actualizar foto de perfil</h2>
                </div>

            <?php else :   ?>

                <div class="column">
                    <h1 class="title">Usuarios</h1>
                    <h2 class="subtitle">Actualizar foto de perfil</h2>
                </div>

            <?php endif;  ?>

        </div>


        <?php if ($existe) : ?>
            <div class="columns ">

                <!-- COLUMNA DERECHA -->

                <div class="column is-9">

                    <!-- SECCION DEL NOMBRE -->
                    <section class=" has-background-grey-darker mb-3 p-2" style="border-radius:2px;">
                        <p class="has-text-white"><b>Nombre completo:</b>&nbsp; <?= $datos_usuario['usuario_nombre'] . ' ' . $datos_usuario['usuario_apellido']; ?></p>

                        <p class="has-text-white"><b>Creado:</b>&nbsp; <?= date('d-m-Y h:i:s A', strtotime($datos_usuario['usuario_creado'])); ?> </p>

                        <p class="has-text-white"><b>Actualizado:</b>&nbsp; <?= date("d-m-Y h:i:s A", strtotime($datos_usuario['usuario_actualizado'])); ?></p>
                    </section>





                    <!-- SECCION DE LA IMAGEN -->

                    <section class="p-2">

                        <?php if (is_file('./app/views/fotos/' . $datos_usuario['usuario_foto'])) : ?>
                            <!-- si existe -->


                            <div class="columns ">

                                <div class="column is-6">
                                    <div class="has-text-centered p-2" style="border:1px solid #333;  border-radius: 6px;">
                                    <h1 class="title is-5">Eliminar foto</h1>
                                        <figure class="">
                                            <img class="has-text-center" src="<?= APP_URL; ?>app/views/fotos/<?= $datos_usuario['usuario_foto'] ?>" alt="" width="350px">
                                        </figure>
                                        <form action="<?= APP_URL ?>app/ajax/usuario_ajax.php" class="FormularioAjax" method="post" autocomplete="off">
                                            <div class="control ">
                                                <input type="hidden" name="modulo_usuario" value="eliminar_foto">
                                                <input type="hidden" name="usuario_id" value="<?= $id; ?>">
                                                <br><br>
                                                <input class="button" type="submit" value="Eliminar foto">
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                

                                <div class="column is-6 " >

                                    <div class="has-text-centered p-2" style="border:1px solid #333; border-radius: 6px; height: 100%;">
                                    <h1 class="title is-5">Actualizar foto</h1>
                                    
                                    <form action="<?= APP_URL; ?>app/ajax/usuario_ajax.php" class="FormularioAjax" method="post" enctype="multipart/form-data">

                                        <input type="hidden" name="modulo_usuario" value="actualizar_foto">
                                        <input type="hidden" name="usuario_id" value="<?= $datos_usuario['usuario_id'];?> " >
                                        <input type="file" class="input" name="usuario_foto_up" id="usuario_foto_up" accept=".jpg, .jpeg, .png">
                                        <br><br>
                                        <input class="button"  type="submit" value="Actualizar foto">
                                    </form>
                                    </div>
                                </div>

                            </div>


                        <?php else : ?>


                            <!-- si no existe -->
                            <div class="has-text-centered">
                                <figure class="image is-128x128 is-inline-block">
                                    <img class="has-text-center" src="<?= APP_URL; ?>app/views/fotos/Avatar.png" alt="" width="100">
                                </figure>
                            </div>

                        <?php endif ?>

                    </section>
                </div>


                <!-- FIN COLUMNA DERECHA -->

            <?php else : ?>

                <!-- MENSAJE DE ERROR -->
                <?php include('./app/views/inc/error_alert.php'); ?>
                <!-- END MENSAJE DE ERROR -->
            <?php endif; ?>




            <!-- COLUMNA IZQUIERDA -->

            <div class="column is-3 ">

                <section class="has-background-grey mb-3 p-2">
                    <p>Columna izquierda</p>
                </section>


            </div>

            <!-- FIN COLUMNA IZQUIERDA -->

            </div>


    </div>
</div>

<script src="<?= APP_URL; ?>app/views/js/mostrar_imagen_seleccionada.js"></script>