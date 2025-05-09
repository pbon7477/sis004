<?php 
require_once('../../config/app.php');
require_once('../views/inc/session_start.php');
require_once('../../autoload.php');

use app\Controllers\SearchController;


if( isset($_POST['modulo_buscador']) ){

    $SearchController = new SearchController();

    if($_POST['modulo_buscador'] == 'buscar'){
        
    }



}else{
    session_destroy();
    header('Location:' . APP_URL . 'login/');
}




?>