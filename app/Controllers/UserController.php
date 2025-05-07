<?php

namespace app\Controllers;

use app\Models\MainModel;
use DateTime;
use Exception;
use Throwable;

class UserController extends MainModel{

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

                return json_encode($alerta);
                exit();
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

        if ($registrar_usuario->rowCount() == 1) {

            $alerta = [
                'tipo' => 'limpiar',
                'titulo' => 'Usuario registrado',
                'texto' => "El usuario $nombre $apellido ha sido registrado exitosamente.",
                'icono' => 'info'
            ];
        } else {
            // En caso de no poder registrar al usuario, borramos la imagen que gurdamos
            if (is_file($images_dir . $foto)) {
                chmod($images_dir . $foto, 0077);
                unlink($images_dir . $foto);
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

    # Listar usuarios
    public function listar_usuarios_controlador($pagina, $numero_registros, $url, $busqueda)
    {

        $pagina = $this->limpiar_cadena($pagina);
        $numero_registros = $this->limpiar_cadena($numero_registros);

        $url = $this->limpiar_cadena($url);
        $url = APP_URL . $url . '/';

        $busqueda = $this->limpiar_cadena($busqueda);

        //tabla
        $tabla = '';
        //Si pagina viene definida y pagina es mayor a 0, convertimos el valor de pagina a un entero
        //en caso contrario, pagina tendra el valor de 1
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;

        $inicio = ($pagina > 0) ? (($pagina * $numero_registros) - $numero_registros) : 0;


        //La busqueda o la consulta para listar los registros
        if (isset($busqueda) && $busqueda != '') {

            $consulta_datos = "SELECT * FROM usuarios 
                               WHERE (
                                        (usuario_id != '" . $_SESSION['id'] . "' AND usuario_id != '1')
                                         AND 
                                        ( usuario_nombre LIKE '%$busqueda%' OR
                                          usuario_apellido LIKE %$busqueda% OR
                                          usuario_email LIKE %$busqueda% OR     
                                          usuario_usuario LIKE %$busqueda%      )
                                     )    
                               ORDER BY usuario_nombre ASC
                               LIMIT " . $inicio . "," . $numero_registros . ";";

            $consulta_total = "SELECT COUNT(usuario_id) FROM usuarios 
                               WHERE (
                                        (usuario_id != '" . $_SESSION['id'] . "' AND usuario_id != '1')
                                         AND 
                                        ( usuario_nombre LIKE '%$busqueda%' OR
                                          usuario_apellido LIKE %$busqueda% OR
                                          usuario_email LIKE %$busqueda% OR     
                                          usuario_usuario LIKE %$busqueda%      )
                                     )";
        } else {

            $consulta_datos = "SELECT * FROM usuarios 
                               WHERE usuario_id != '" . $_SESSION['id'] . "'
                               AND usuario_id != '1'
                               ORDER BY usuario_nombre ASC
                               LIMIT " . $inicio . "," . $numero_registros . ";";

            $consulta_total = "SELECT COUNT(usuario_id) FROM usuarios 
                               WHERE usuario_id != '" . $_SESSION['id'] . "'
                               AND usuario_id != '1';";
        }


        //obtenemos los datos
        $datos = $this->ejecutar_consulta($consulta_datos);
        $datos = $datos->fetchAll();

        //obtenemos el total de registros
        $total = $this->ejecutar_consulta($consulta_total);
        $total = (int) $total->fetchColumn();


        $numero_paginas = ceil($total / $numero_registros);

        //creamos la tabla
        $tabla .= '<div class="table-container">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <thead>
                            <tr>
                                <th class="has-text-centered">#</th>
                                <th class="has-text-centered">Nombre</th>
                                <th class="has-text-centered">Usuario</th>
                                <th class="has-text-centered">Email</th>
                                <th class="has-text-centered">Creado</th>
                                <th class="has-text-centered">Actualizado</th>
                                <th class="has-text-centered">Foto</th>
                                <th class="has-text-centered" colspan="3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';


        if ($total >= 1 && $pagina <= $numero_paginas) {

            $contador = $inicio + 1;
            $pagina_inicio = $inicio + 1;

            foreach ($datos as $dato) {

                $tabla .= '
                                    <tr class="has-text-start">
                                        <td>' . $contador . '</td>
                                        <td><small>' . $dato['usuario_nombre'] . ' ' . $dato['usuario_apellido'] . '(' . $dato['usuario_id'] .  ')</small></td>
                                        <td>' . $dato['usuario_usuario'] . '</td>
                                        <td>' . $dato['usuario_email'] . ' </td>
                                        <td>' . date("d-m-Y h:i:s A", strtotime($dato['usuario_creado']))  . '</td>
                                        <td>' . date("d-m-Y h:i:s A", strtotime($dato['usuario_actualizado']))  . '</td>
                                        
                                        <td>
                                            <a href="' . APP_URL . 'userPhoto/' . $dato['usuario_id'] . '/" class="button is-info  is-small">Foto</a>
                                        </td>
                                        
                                        <td>
                                            <a href="' . APP_URL . 'userUpdate/' . $dato['usuario_id'] . '/" class="button is-warning  is-small">Actualizar</a>
                                        </td>

                                        
                                        <td>
                                            <form action="' . APP_URL . 'app/ajax/usuario_ajax.php" class="FormularioAjax" method="POST" autocomplete="off" >
                                                <input type="hidden" name="modulo_usuario" value="eliminar">
                                                <input type="hidden" name="usuario_id" value="' .  $dato['usuario_id'] . '">
                                                <button type="submit" class="button is-danger is-small">Elimnar</button>
                                            </form>
                                        </td>
                                    </tr>
                                ';

                $contador++;
            }

            $pagina_final = $contador - 1;
        } else {

            if ($total >= 1) {
                $tabla .= '<tr class="has-text-centered">
                                       <td colspan="7">
                                         <a href="' . $url . '1/" class="button is-link is-rounded is-small my-4 ">Haga click para recargar el listado.</a>
                                       </td>                    
                                    </tr>';
            } else {
                $tabla .= '<tr class="has-text-centered">
                                       <td colspan="8">
                                          <p class="my-2">No hay registros en el sistema.</p>
                                       </td>
                                  </tr>';
            }
        }




        $tabla .= '     </tbody>
                    </table>
                  </div>';


        if ($total >= 1 && $pagina <= $numero_paginas) {
            $tabla .= '
                        <p class="has-text-right mb-3">
                            Mostrando usuarios <b>' . $pagina_inicio . '</b> al <b>' . $pagina_final . '</b> de un <b>total de ' . $total . '</b>
                        </p>
                      ';

            $tabla .= $this->paginador_tablas($pagina, $numero_paginas, $url, 7);
        }

        return $tabla;
    }


    # Eliminar usuario
    public function eliminar_usuario_controlador()
    {

        $id = $this->limpiar_cadena($_POST['usuario_id']);

        # Verificando usuario principal #
        if ($id == 1) {
            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'No es posible eliminar al usuario principal',
                'icono' => 'error'
            ];

            return json_encode($alerta);
        }

        # Verificando si el usuario existe #

        $sql = "SELECT * FROM usuarios WHERE usuario_id = '$id'";
        $datos = $this->ejecutar_consulta($sql);

        if ($datos->rowCount() <= 0) {

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'ocurrió un error inesperado',
                'texto' => 'El usuario no existe en la base de datos.',
                'icono' => 'error'
            ];

            return json_encode($alerta);;
        } else {
            $datos = $datos->fetch();
        }

        # Eliminando al usuario #

        $eliminar_usuario = $this->eliminar_registro('usuarios', 'usuario_id', $id);

        if ($eliminar_usuario->rowCount() == 1) {

            //Eliminamos la foto del usuario del directorio 
            if (is_file('../views/fotos/' . $datos['usuario_foto'])) {
                chmod('../views/fotos/' . $datos['usuario_foto'], 0777);
                unlink('../views/fotos/' . $datos['usuario_foto']);
            }

            $alerta = [
                'tipo' => 'recargar',
                'titulo' => 'Usuario eliminado',
                'texto' => 'El usuario ' . ucwords($datos['usuario_nombre']) . ' ' . ucwords($datos['usuario_apellido']) . ' ha sido eliminado exitosamente de la base de datos.',
                'icono' => 'success'
            ];
        } else {

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'ocurrió un error inesperado',
                'texto' => 'No ha sido posible eliminar al usuario ' . ucwords($datos['usuario_nombre']) . ' ' . ucwords($datos['usuario_apellido']) . '',
                'icono' => 'error'
            ];
        }

        return json_encode($alerta);
    }


    # Actualizar usuario

    public function actualizar_usuario_controlador()
    {

        $id = $this->limpiar_cadena($_POST['usuario_id']);
        # Comprobando si el usuario existe

        $sql = "SELECT * FROM usuarios WHERE usuario_id = '$id';";
        $query = $this->ejecutar_consulta($sql);

        if ($query->rowCount() <= 0) {
            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'El usuario no existe en el sistema.',
                'icono' => 'error'
            ];

            return json_encode($alerta);
        } else {
            $datos_usuario = $query->fetch();
        }


        # Verificamos que  el administrador lleno los campos de sus credenciales

        $admin_usuario = $this->limpiar_cadena($_POST['administrador_usuario']);
        $admin_clave = $this->limpiar_cadena($_POST['administrador_clave']);

        if ($admin_usuario == '' && $admin_clave == '') {
            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'No ha llenado todos los campos que son obligatorios, que corresponden a  su CLAVE y USUARIO para poder realizar la actualización. ',
                'icono' => 'error'
            ];
            return json_encode($alerta);
        }

        # verificamos la integridad de las credenciales del ADMINISTRADOR

        if ($this->verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}', $admin_usuario)) {

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'Su USUARIO no coincide con el formato solicitado.',
                'icono' => 'error'
            ];

            return json_encode($alerta);
        }

        if ($this->verificar_datos('[a-zA-Z0-9$@.\-]{6,100}', $admin_clave)) {

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'Su CLAVE no coincide con el formato solicitado.',
                'icono' => 'error'
            ];

            return json_encode($alerta);
        }

        # Verificando al ADMINISTRADOR
        $sql = "SELECT * FROM usuarios WHERE usuario_usuario = '$admin_usuario'  AND usuario_id = " . $_SESSION['id'] . ";";
        $check_admin = $this->ejecutar_consulta($sql);

        if ($check_admin->rowCount() == 1) {

            // Verificamos que la contraseña del ADMINISTRADOR COINCIDA CON LA QUE ESTA EN LA BASE DE DATOS 
            $datos_admin = $check_admin->fetch();

            if ($datos_admin['usuario_usuario'] != $admin_usuario  ||  !password_verify($admin_clave, $datos_admin['usuario_clave'])) {

                $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'USUARIO o CLAVE de administrador incorrectos.(1)',
                    'icono' => 'error'
                ];

                return json_encode($alerta);
            }
        } else {
            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'USUARIO o CLAVE de administrador incorrectos.(0)',
                'icono' => 'error'
            ];

            return json_encode($alerta);
        }



        # ALMACENANDO DATOS DEL USUARIOS ( ACTUALIZACIÓN )

        # Almacenando datos #
        $nombre = $this->limpiar_cadena($_POST['usuario_nombre']);
        $apellido = $this->limpiar_cadena($_POST['usuario_apellido']);
        $usuario = $this->limpiar_cadena($_POST['usuario_usuario']);

        $email = $this->limpiar_cadena($_POST['usuario_email']);

        $clave_1 = $this->limpiar_cadena($_POST['usuario_clave_1']);
        $clave_2 = $this->limpiar_cadena($_POST['usuario_clave_2']);



        # verificamos campos obligatorios #
        if ($nombre == '' || $apellido == '' || $usuario == '') {

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



        # verificar email (El email no es obligatorio, 
        # pero si viene con algo y lo que viene es diferente de los que hay en la base de datos?)

        if ($email != '' && $datos_usuario['usuario_email'] != $email) {
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



        # Verificamos que la clave tenga algo 

        if ($clave_1 != '' && $clave_2 != '') {

            # Si trae algo, verificamos la intgridad de las clave 1 y 2
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


            // Verificamos igualdad de las claves.    
            if ($clave_1 !== $clave_2) {

                $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'Los PASSWORD no coinciden.',
                    'icono' => 'error'
                ];

                return json_encode($alerta);
                exit();

            }else{

                // Si son iguales, Encriptamos el password.   
                $clave = password_hash($clave_1, PASSWORD_BCRYPT, ["cost" => 10]);

            }

        } else {

            //Si la clave viene vacia, dejamos la que existe en la base de datos.
            $clave = $datos_usuario['usuario_clave'];
        }



        # verificamos si el usuario_usuaurio es desigual al entrante
        if( $datos_usuario['usuario_usuario'] != $usuario ){
            
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

        }else{
            $usuario = $datos_usuario['usuario_usuario'];
        }


        # PREPARAMOS EL ARRAY PARA ACTUALIZAR LOS DATOS DEL USUARIO

        $usuario_datos_up = [
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
                "campo_nombre" => "usuario_actualizado",
                "campo_marcador" => ":usuario_actualizado",
                "campo_valor" => date('Y-m-d H:i:s')
            ]
        ];

        $condicion = [
            'condicion_campo' => 'usuario_id',
            'condicion_marcador' => ':id',
            'condicion_valor' => $id
        ];

        # Actualizando datos
        $actualizar_usuario = $this->actualizar_datos('usuarios',$usuario_datos_up, $condicion);

        if( $actualizar_usuario ){

            // Si es mi misma cuenta la que estoy almacenando, sobrescribimos los valores de las variables de session actual.

            if($id == $_SESSION['id']){
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellido'] = $apellido;
                $_SESSION['usuario'] = $usuario;
            }


            $alerta = ['tipo' =>'recargar',
                       'titulo' => 'Usuario actualizado',
                       'texto' => 'Los datos del usuario ' . $datos_usuario['usuario_nombre'] . ' ' . $datos_usuario['usuario_apellido'] . ' han sido actualizados exitosamente.',
                       'icono' => 'success'
                      ];
        }else{
            $alerta = ['tipo' =>'simple',
                       'titulo' => 'ocurrió un error inesperado.',
                       'texto' => 'No ha sido posible actualizar los datos del usuario.',
                       'icono' => 'error'
                      ];

        }

        return json_encode($alerta);
    }



    # Eliminar foto

    public function eliminar_foto_controlador(){
        
        $id = $this->limpiar_cadena($_POST['usuario_id']);

        $alerta = [
            'tipo' => 'simple',
            'titulo' => 'Esta llegando al controlador',
            'texto' => 'Aqui sera en donde ELIMINAREMOS la foto del usuario con el id: '. $id . '',
            'icono' => 'error'
        ];

        return json_encode($alerta);
        
    }




    # Controlador para Actualizar foto del usuario # 

    public function actualizar_foto_usuario_controlador(){


        try {

         $id = $this->limpiar_cadena($_POST['usuario_id']);

        # Comprobando si el usuario existe
        $sql = "SELECT * FROM usuarios WHERE usuario_id = '$id';";
        $query = $this->ejecutar_consulta($sql);

        # Si no existe
        if ($query->rowCount() <= 0) {
            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'El usuario no existe en el sistema.',
                'icono' => 'error'
            ];

            return json_encode($alerta);

        } else {
           # Si exsite, almacenamos sus datos en el array $datos_usuario
            $datos_usuario = $query->fetch();
            
        }


        

        #Comprobamos si se ha enviado una imagen valida
        if($_FILES['usuario_foto_up']['name'] == '' && $_FILES['usuario_foto_up']['size'] <= 0){
            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'No se ha seleccionado una imagen valida.',
                'icono' => 'error'
            ];

            return json_encode($alerta);

        }

        # Creando el directorio
        # Directorio de imagenes

        
        $fotos_dir = '../views/fotos/';

        //Si no existe el directorio...
        if( !file_exists($fotos_dir) ){

           
            //...creamos el directorio
           
            if (!mkdir($fotos_dir, 0777,true)) {                          

                $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'Error al crear el directorio.',
                    'icono' => 'error'
                ];
    
                return json_encode($alerta);

            }
        }

        # Verificando el formato de las imagenes


    
        

        if (
            mime_content_type($_FILES['usuario_foto_up']['tmp_name']) != 'image/jpg'  &&
            mime_content_type($_FILES['usuario_foto_up']['tmp_name']) != 'image/jpeg'  &&
            mime_content_type($_FILES['usuario_foto_up']['tmp_name']) != 'image/png'
        ){
            
            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'La imagen que ha seleccionado es de una formato no permitido.',
                'icono' => 'error'
            ];

            return json_encode($alerta);
        }

        #Verificando el peso del la imagen
        if( ($_FILES['usuario_foto_up']['size'] /1024) > 5120  ){
            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'La imagen que ha seleccionado supera el peso permitido(5MB).',
                'icono' => 'error'
            ];

            return json_encode($alerta);

        }

        # Nombre de la foto:
        //Aqui verificamos si existe una imagen
        if($datos_usuario['usuario_foto'] != ''){

            //Despedasamos el usuario_foto (existente en la BBDD) por el punto para quitar la extencion
            $foto = explode('.', $datos_usuario['usuario_foto']);
            $foto = $foto[0];
            
        }else{
            
            # Si no existe el nombre de la foto en la BBDD ...definimos el nombre de la Imagen
            $foto = str_ireplace(' ','_',$datos_usuario['usuario_nombre']);
            $fecha = new DateTime();            
            $foto = $foto . '_' . $fecha->getTimestamp();                   

        }


        # Extencion de la imagen
        switch( mime_content_type($_FILES['usuario_foto_up']['tmp_name']) ){
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

        chmod($fotos_dir,0777);

        # Moviendo imagen al directorio
        $moviendo_foto = move_uploaded_file($_FILES['usuario_foto_up']['tmp_name'], $fotos_dir . $foto);
        if( !$moviendo_foto  ){
            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'Ocurrió un error inesperado',
                'texto' => 'No es posible subir la imagen en este momento..',
                'icono' => 'error'
            ];

            return json_encode($alerta);
            
        }


        # Eliminando imagen existente
        //Si existe el archivo de imagen y ademas es desigual a el nombre de imagen que hemos crerado en '$foto'
        if(is_file($fotos_dir . $datos_usuario['usuario_foto'])  && $datos_usuario['usuario_foto'] != $foto ){

            //Damos permiso de escritura al directorio
            chmod($fotos_dir . $datos_usuario['usuario_foto'], 0777);
            unlink($fotos_dir . $datos_usuario['usuario_foto'] );

        }

        # Actualizamos los datos
        $usuario_datos_up = [
            [
            "campo_nombre"=>"usuario_foto",
            "campo_marcador" => ":foto",
            "campo_valor" => $foto
            ],
            [
            "campo_nombre" => "usuario_actualizado",
            "campo_marcador" => ":actualizado",
            "campo_valor" => date("Y-m-d H:i:s")
            ]
        ];

        $condicion = [
            "condicion_campo" => "usuario_id",
            "condicion_marcador" => ":id",
            "condicion_valor" => $id
        ];

        $actualizando_datos = $this->actualizar_datos("usuarios",$usuario_datos_up, $condicion); 


        if( $actualizando_datos ){
            
            if( $id == $_SESSION['id'] ){
                $_SESSION['usuario_foto'] = $foto;
            }

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Foto actualizada",
                "texto" => "La foto del usuario ". $datos_usuario['usuario_nombre'] . " " . $datos_usuario['usuario_apellido'] . " ha sido actualizada exitosamente.",
                 "icono" => "success"            
        ];

        }else{

            $alerta = [
                'tipo' => 'recargar',
                'titulo' => 'Ocurrió un error inesperado',
                "texto" => "No ha sido posible actualizar la imagen del usuario ". $datos_usuario['usuario_nombre'] . " " . $datos_usuario['usuario_apellido'] . ". ",
                'icono' => 'warning'
            ];

        }

        return json_encode($alerta);




        }catch( Exception $e  ){
            echo "Error: " . $e->getMessage() . '  ' . '<br>Linea: ' . $e->getLine();  
        }



        
    }


}
