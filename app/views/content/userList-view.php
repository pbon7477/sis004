<div class="container-fluid">
    <div class="container is-fluid my-5">

        <div class="columns">
            <div class="column is-12">
                <div class="is-flex is-justify-content-space-between">
                    <div>
                        <h1 class="title">Usurios</h1>
                        <h1 class="subtitle">Lista de usurios</h1>
                    </div>
                <div>
                    <a href="<?= APP_URL;?>userNew/" type="button" class="button is-primary">Nuevo usuario</a>
                </div>
                </div>


            </div>
        </div>

        <div class="columns">
            <div class="column is-12" style="border: 1px solid #7777;">

                <div class="container ">
                    <?php 
                        
                        use app\Controllers\UserController;

                        $UserController = new UserController();
                       echo  $UserController->listar_usuarios_controlador($url[1],10,$url[0],'');

                    ?>


                </div>

            </div>
        </div>

    </div>
</div>