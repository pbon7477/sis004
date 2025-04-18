<?php 

namespace app\Controllers;
use app\Models\MainModel;

class UserController extends MainModel {

    # Controlador para registrar un usuario #
    public function registrar_usuario_controlador(){
        # Almacenando datos #
        $nombre = $this->limpiar_cadena($_POST['usuario_nombre']);
        $apellido = $this->limpiar_cadena($_POST['usuario_apellido']);
        $usuario = $this->limpiar_cadena($_POST['usuario_usuario']);

        $email = $this->limpiar_cadena($_POST['usuario_email']);

        $clave1 = $this->limpiar_cadena($_POST['usuario_clave_1']);
        $clave2 = $this->limpiar_cadena($_POST['usuario_clave_2']);

        # verificamos campos obligatorios #
        if($nombre == '' || $apellido == '' || $usuario == '' || $clave1 == '' || $clave2 == ''){

            $alerta = ['tipo' => 'simple',
            'titulo' => 'Ocurrió un error inesperado',
            'texto' => 'No se han llenado todos los campos obligatorios',
            'icono' => 'error'];

            return json_encode($alerta);               

        }else{
            $alerta = ['tipo' => 'simple',
            'titulo' => 'Muy Bien',
            'texto' => 'Lograste sacar el bug, Felicitaciones!!...vamos bien Pablo!',
            'icono' => 'success'];

            return json_encode($alerta); 
        }
    }
    
}