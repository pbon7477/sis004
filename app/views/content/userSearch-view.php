<?php

use app\Controllers\UserController;

$UserController = new UserController();

$url = explode('/',$_GET['views']);

?>


<div class="container-fluid">

    <div class="container my-5">
        <div class="columns">


            <div class="column">
                <h1 class="title">Usuarios</h1>
                <h2 class="subtitle">Buscar usuario</h2>
            </div>



        </div>




        <div class="columns">

            <!-- columna derecha -->
            <div class="column is-9">

                <?php  if( !isset($_SESSION[$url[0]])  && empty($_SESSION[$url[0]]) ) :  ?>
                <!-- FORMULARIO DE BUSQUEDA -->

                <section style="border:1px solid #222;">
                    <h1 class="is-size-5 has-text-primary has-background-dark p-2">Buscador:</h1>
                    <div class="p-2">

                        <form action="<?= APP_URL; ?>ajax/buscadorAjax.php" class="FormularioAjax" method="post" autocomplete="off">

                            <input type="hidden" name="modulo_buscador" value="buscar">
                            <input type="hidden" name="modulo_url" value="<?= $url[0]; ?>">

                            <div class="field is-grouped ">
                                <div class="control is-expanded">

                                    <input class="input is-small" type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" name="txt_buscador" placeholder="¿Que esta buscando?" maxlength="30" required>
                                </div>
                                <div class="control">
                                    <input class="button is-small is-info" type="submit" value="buscar">
                                </div>
                            </div>

                        </form>


                    </div>
                </section>
                
                <!-- END FORMULARIO DE BUSQUEDA -->

                
                
                
                
                
                
                
                <?php else : ?>
                <!-- FORMULARIO PARA ELIMINAR LA BUSQUEDA Y LISTADO -->
                <section style="border:1px solid #222;">
                    <h1 class="is-size-5 has-text-primary has-background-dark p-2">Resultados de la busqueda:</h1>
                    <div class="p-2">

                        <form action="<?= APP_URL; ?>ajax/buscadorAjax.php" class="FormularioAjax" method="post" autocomplete="off">

                            <input type="hidden" name="modulo_buscador" value="eliminar">
                            <input type="hidden" name="modulo_url" value="<?= $url[0]; ?>">

                            <div class="field is-grouped ">
                                <div class="control is-expanded">
                                   
                                    <p class="">Estas buscando <b><?= $_SESSION[$url[0] ];?></b></p>
                                </div>
                                <div class="control">
                                    <input class="button is-small is-danger" type="submit" value="Eliminar busqueda">
                                </div>
                            </div>

                        </form>


                        
                    </div>
                </section>
                
                <!--- Listado de la busqueda --->
                <?php 
                    
                    $UserController->listar_usuarios_controlador($url[1],10,$url[0],$_SESSION[$url[0]]);
                    
                    ?>
                <!-- END FORMULARIO PARA ELIMINAR LA BUSQUEDA Y LISTADO -->

                <?php endif; ?>



            </div>
            <!-- end columna derecha -->



            <!-- columna izquierda -->
            <div class="column is-3">
                <section style="border:1px solid #222;">
                    <h1 class="is-size-5 has-text-primary has-background-dark p-2">Columna izquierda</h1>
                    <div class="p-2">
                        <p>Seccion #2</p>
                        <h1>Quedamos en el video 57, nos falta implementar la busqueda</h1>

                    </div>
                </section>
            </div>
            <!-- end columna izquierda -->
        </div>

    </div>


    <!--- fin ---->



</div>

<script src="<?= APP_URL; ?>app/views/js/mostrar_imagen_seleccionada.js"></script>