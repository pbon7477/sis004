<?php

namespace app\Controllers;

use app\Models\MainModel;
use DateTime;

class UserController extends MainModel
{

    # Controlador para registrar un usuario #
    public function registrar_usuario_controlador()
    {
        # Almacenando datos #
        $nombre = $this->limpiar_cadena($_POST['usuario_nombre']);
        $apellido = $this->limpiar_cadena($_POST['usuario_apellido']);
        $usuario = $this->limpiar_cadena($_POST['usuario_usuario']);

        $email = $this->limpiar_cadena($_POST['usuario_email']);

        $clave_1 = $this->limpiar_cadena($_POST['usuario_clave_1']);
        $clave_2 = $this->limpiar_cadena($_POST['usuario_clave_2']);



        # verificamos campos obligatorios #
        if ($nombre == '' || $apellido == '' || $usuario == '' || $clave_1 == '' || $clave_2 == '') {

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'No se han llenado todos los campos obligatorios',
                'icono' => 'error'
            ];

            return json_encode($alerta);
            exit();
        }

        # verificar integridad de los datos #

        //Nombre
        if ($this->verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}', $nombre)) {

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'El NOMBRE no coincide con el formato solicitado.',
                'icono' => 'error'
            ];

            return json_encode($alerta);
            exit();
        }

        //Apellido
        if ($this->verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}', $apellido)) {

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'El APELLIDO no coincide con el formato solicitado.',
                'icono' => 'error'
            ];

            return json_encode($alerta);
            exit();
        }

        //Usuario
        if ($this->verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}', $usuario)) {

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'El USUARIO no coincide con el formato solicitado.',
                'icono' => 'error'
            ];

            return json_encode($alerta);
            exit();
        }



        # verificar email (El email no es obligatorio)
        if ($email != '') {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                // Verificamos que el email no exista en la BBDD
                $sql = "SELECT usuario_email FROM usuarios WHERE usuario_email = '$email';";
                $check_email = $this->ejecutar_consulta($sql);

                if ($check_email->rowCount() > 0) {

                    $alerta = [
                        'tipo' => 'simple',
                        'titulo' => 'Ocurrió un error inesperado',
                        'texto' => 'El EMAIL que esta intentando introducir ya se encuentra registrado.',
                        'icono' => 'error'
                    ];

                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'Ha ingresado un EMAIL no valido.',
                    'icono' => 'error'
                ];

                return json_encode($alerta);
                exit();
            }
        }



        # Verificamos la intgridad de las clave 1 y 2

        if ($this->verificar_datos('[a-zA-Z0-9$@.\-]{6,100}', $clave_1) || $this->verificar_datos('[a-zA-Z0-9$@.\-]{6,100}', $clave_2)) {

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'Los PASSWORD no coinciden con el formato solicitado.',
                'icono' => 'error'
            ];

            return json_encode($alerta);
            exit();
        }

        // Verificamos igualdad de las claves    
        if ($clave_1 !== $clave_2) {

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'Los PASSWORD no coinciden.',
                'icono' => 'error'
            ];

            return json_encode($alerta);
            exit();
        } else {
            //Encriptamos el password    
            $clave = password_hash($clave_1, PASSWORD_BCRYPT, ["cost" => 10]);
        }


        # Verificamos que el usuario no exista en la base de datos
        $sql = "SELECT usuario_usuario FROM usuarios WHERE usuario_usuario = '$usuario';";
        $check_usuario = $this->ejecutar_consulta($sql);

        if ($check_usuario->rowCount() > 0) {
            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'El USUARIO que esta intentando introducir ya se encuentra registrado.',
                'icono' => 'error'
            ];

            return json_encode($alerta);
            exit();
        }


        # IMAGEN ( Procesar y subir ) #
        //creamos el nombre del Directorio de imagenes
        $images_dir = '../views/fotos/';

        //Verificamos si se ha seleccionado una imagen
        if ($_FILES['usuario_foto']['name'] != '' && $_FILES['usuario_foto']['size'] > 0) {

            # Creando directorio

            //Si el directorio NO existe?
            if (!file_exists($images_dir)) {

                //...y si no se ha podido crear el directorio?
                if (!mkdir($images_dir, 0077)) {
                    $alerta = [
                        'tipo' => 'simple',
                        'titulo' => 'Ocurrió un error inesperado',
                        'texto' => 'Error al crear el directorio.',
                        'icono' => 'error'
                    ];

                    return json_encode($alerta);
                    exit();
                }
            }

            # Verificando formato de imagen( .jpg, .jpeg y .png)
            if (
                mime_content_type($_FILES['usuario_foto']['tmp_name']) != 'image/jpg'  &&
                mime_content_type($_FILES['usuario_foto']['tmp_name']) != 'image/jpeg'  &&                
                mime_content_type($_FILES['usuario_foto']['tmp_name']) != 'image/png'
            ) {

                $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'La imagen que ha seleccionado es de un formato no permitido.',
                    'icono' => 'error'
                ];

                return json_encode($alerta);
                exit();
            }


            # Verificando peso de la imagen (5MB)
            if (($_FILES['usuario_foto']['size'] / 1024) > 5120) {

                $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'La imagen que ha seleccionado supera el peso permitido.',
                    'icono' => 'error'
                ];

                return json_encode($alerta);
                exit();
            }


            # Definimos el nombre de la Imagen
            $fecha = new DateTime();

            $foto = str_ireplace(' ', '_', $nombre);
            $foto = $foto . '_' . $fecha->getTimestamp();

            # Extencion de la imagen
            switch (mime_content_type($_FILES['usuario_foto']['tmp_name'])) {
                case 'image/jpg':
                    $foto = $foto . '.jpg';
                    break;
                case 'image/jpeg':
                    $foto = $foto . '.jpeg';
                    break;
                case 'image/png':
                    $foto = $foto . '.png';
                    break;               
            }


            # Damos permisos de lectura y escritura al programa para poder escribir la imagen
            chmod($images_dir, 0077);

            # Movemos la imagen al directoro
            $foto_guardada = move_uploaded_file($_FILES['usuario_foto']['tmp_name'], $images_dir . $foto);

            if (!$foto_guardada) {
                $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'No es posible subir la imagen en este momento..',
                    'icono' => 'error'
                ];
            }

        } else {
            $foto = '';
        }


        # registro de datos del usuario

        $usuario_datos_reg = [
            [ 
              "campo_nombre" => "usuario_nombre",
              "campo_marcador" => ":nombre",
              "campo_valor" => $nombre
            ],
            [ 
              "campo_nombre" => "usuario_apellido",
              "campo_marcador" => ":apellido",
              "campo_valor" => $apellido
            ],
            [ 
              "campo_nombre" => "usuario_email",
              "campo_marcador" => ":email",
              "campo_valor" => $email
            ],
            [ 
              "campo_nombre" => "usuario_usuario",
              "campo_marcador" => ":usuario",
              "campo_valor" => $usuario
            ],
            [ 
              "campo_nombre" => "usuario_clave",
              "campo_marcador" => ":clave",
              "campo_valor" => $clave
            ],
            [ 
              "campo_nombre" => "usuario_foto",
              "campo_marcador" => ":foto",
              "campo_valor" => $foto
            ],
            [ 
              "campo_nombre" => "usuario_creado",
              "campo_marcador" => ":usuario_creado",
              "campo_valor" => date('Y-m-d H:i:s')
            ],
            [ 
              "campo_nombre" => "usuario_actualizado",
              "campo_marcador" => ":usuario_actualizado",
              "campo_valor" => date('Y-m-d H:i:s')
            ]
        ];


        $registrar_usuario = $this->guardar_datos("usuarios", $usuario_datos_reg);

        if( $registrar_usuario->rowCount() == 1 ){

            $alerta = [
                'tipo' => 'limpiar',
                'titulo' => 'Usuario registrado',
                'texto' => "El usuario $nombre $apellido ha sido registrado exitosamente.",
                'icono' => 'info'
            ];

        }else{
            // En caso de no poder registrar al usuario, borramos la imagen que gurdamos
            if( is_file( $images_dir . $foto ) ){
                chmod($images_dir . $foto ,0077);
                unlink($images_dir . $foto );
            }

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'No es posible registrar al usuario, por favor inténtelo nuevamente.',
                'icono' => 'error'
            ];

        }

        return json_encode($alerta);
    }
}
