<?php 
require_once('./config/app.php');
require_once('./autoload.php');
require_once('./app/views/inc/session_start.php');

if( isset($_GET['views']) ){
    $url = explode("/", $_GET['views']);
    
}else{
    $url = ["login"];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include_once('./app/views/inc/head.php'); ?>
</head>
<body>


<?php 
use app\Controllers\LoginController;
use app\Controllers\ViewsControllers;

$LoginController = new LoginController();


$ViewController = new ViewsControllers();
$vista = $ViewController->obtenerVistasControlador($url[0] );

if($vista == 'login' || $vista == '404'){
  require_once('./app/views/content/' . $vista . '-view.php');

}else{

    # cerrar session si no se ha logeado
    if( !isset($_SESSION['id']) || !isset($_SESSION['nombre']) || !isset($_SESSION['usuario']) || $_SESSION['id'] == '' || $_SESSION['nombre'] == '' || $_SESSION['usuario'] == '' ){
      $LoginController->cerrar_session_controlador();
      exit();
    }
    
    # si se inicio session, carga el navbar y las vistas
    require_once( './app/views/inc/navbar.php' );
    require_once($vista);
}

?>


    
<?php include_once('./app/views/inc/scripts.php'); ?>
</body>
</html>
