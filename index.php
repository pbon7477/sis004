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
use app\Controllers\ViewsControllers;

$ViewController = new ViewsControllers();
$vista = $ViewController->obtenerVistasControlador($url[0] );

if($vista == 'login' || $vista == '404'){
  require_once('./app/views/content/' . $vista . '-view.php');
}else{
  require_once( './app/views/inc/navbar.php' );
  require_once($vista);
}

?>


    
<?php include_once('./app/views/inc/scripts.php'); ?>
</body>
</html>
