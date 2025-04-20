<?php

namespace app\Controllers;

use app\Models\MainModel;

class LoginController extends MainModel
{

    # Controlador para iniciar sesion #
    public function iniciar_session_controlador()    {

        # 1. Almacenamos los datos en variable

        $usuario = $this->limpiar_cadena($_POST['login_usuario']);
        $clave = $this->limpiar_cadena($_POST['login_clave']);

        # 2. Verificando campos obligtorios
        if ($usuario == '' || $clave == '') {
            echo "<script>
                    Swal.fire({
                        icon:'error',
                        title: 'Ocurrió un error inesperado.',
                        text:'No ha llenado todos los campos que son obligatorios.',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#222'
                    });
                </script>";

        }else{

            # 3. Verificando integridad de los datos #
            
            
            # 4. Verificando integridad de los datos del nombre de usuario #
            
            if( $this->verificar_datos('[a-zA-Z0-9]{4,20}', $usuario )  ){

                echo "<script>
                    Swal.fire({
                        icon:'error',
                        title: 'Ocurrió un error inesperado.',
                        text:'El USUARIO no coincide con el formato solicitado.',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#222'
                    });
                </script>";

            }else{

                # 5. Verificando integridad de la clave #
                if( $this->verificar_datos('[a-zA-Z0-9$@.\-]{6,100}', $clave )  ){

                    echo "<script>
                    Swal.fire({
                        icon:'error',
                        title: 'Ocurrió un error inesperado.',
                        text:'La CLAVE no coincide con el formato solicitado.',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#222'
                    });
                </script>";

                }else{

                    # 6. Verificando que el usuario exista en la base de datos
                    $sql = "SELECT * FROM usuarios WHERE usuario_usuario = '$usuario';"; 
                    $check_usuario = $this->ejecutar_consulta($sql);

                    if($check_usuario->rowCount() == 1 ){

                        # 7. Traemos todos los datos del usuario encontrado
                        $check_usuario = $check_usuario->fetch();

                        # 8. verificando si el usuario y clave coinciden con lo que hay en la base de datos
                        if($check_usuario['usuario_usuario'] == $usuario  &&  password_verify($clave,$check_usuario['usuario_clave']) ){

                            # 9. Creamos las variables de session
                            $_SESSION['id'] = $check_usuario['usuario_id'];
                            $_SESSION['nombre'] = $check_usuario['usuario_nombre'];
                            $_SESSION['apellido'] = $check_usuario['usuario_apellido'];
                            $_SESSION['usuario'] = $check_usuario['usuario_usuario'];
                            $_SESSION['foto'] = $check_usuario['usuario_foto'];

                            # 10. Verificando si se han enviado los encabezados( para ver con que redirijimos)
                            if( headers_sent() ){
                                echo '<script>
                                    window.location.href="'. APP_URL . '/dashboard"  
                                      </script>';    
                            }else{
                                header('Location:' . APP_URL . '/dashboard');
                            }



                        }else{
                            echo "<script>
                                Swal.fire({
                                    icon:'error',
                                    title: 'Ocurrió un error inesperado.',
                                    text:'Usuario o clave incorrectos.',
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor: '#222'
                                });
                            </script>";
                        }

                    }else{
                        echo "<script>
                                Swal.fire({
                                    icon:'error',
                                    title: 'Ocurrió un error inesperado.',
                                    text:'Usuario o clave incorrectos.',
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor: '#222'
                                });
                            </script>";

                    }

                }

            }
        }
    }

    # Controlador para cerrar sesion #
    public function cerrar_session_controlador(){
        session_destroy();

        if( headers_sent() ){
            echo '<script>
                    window.location.href="' . APP_URL  . 'login/";
                 </script>';
        }else{
            header('Location:' . APP_URL . 'login/');
        }
    }
}
