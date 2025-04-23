<?php 
require_once('../../config/app.php');
require_once('../views/inc/session_start.php');
require_once('../../autoload.php');

use app\Controllers\UserController;

if( isset($_POST['modulo_usuario']) ){

    $UserController = new UserController();

    if( $_POST['modulo_usuario'] == 'registrar'){
        echo $UserController->registrar_usuario_controlador();
    }

    if( $_POST['modulo_usuario'] == 'eliminar' ){
        echo $UserController->eliminar_usuario_controlador();
    }

}else{
    session_destroy();
    header('Location:' . APP_URL . 'login/');
}