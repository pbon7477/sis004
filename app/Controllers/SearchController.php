<?php

namespace app\Controllers;

use app\Models\MainModel;
use Exception;

class SearchController extends MainModel
{

    # -- Controlador modulos de busqueda --
    public function modulos_busqueda_controlador($modulo)
    {
        $lista_modulos = ['userSearch'];

        if (in_array($modulo, $lista_modulos)) {
            return false;
        } else {
            return true;
        }
    }


    # -- Controlador para iniciar busquedas --

    public function iniciar_buscador_controlador()    {
        try {

            // Recibiendo url y el texto de busqueda
            $modulo_url = $this->limpiar_cadena($_POST['modulo_url']);
            $texto_busqueda = $this->limpiar_cadena($_POST['texto_busqueda']);

            // Comprobando si el modulo(url) que estamos consultando esta permitido en el sistema 
            if ($this->modulos_busqueda_controlador($modulo_url)) {
                $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'No podemos procesar la petición en este momento.',
                    'icono' => 'error'
                ];

                return json_encode($alerta);
            }

            // Comprobar que que el texto de busqueda no venga vacio
            if ($texto_busqueda == '') {
                $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'Introduzca un termino de búsqueda.',
                    'icono' => 'error'
                ];

                return json_encode($alerta);
            }

            //Integridad de los datos
            // Comprobando que el termino de busqueda coincida con el formato solicitado
            if ($this->verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ@. ]{1,30}', $texto_busqueda)) {
                $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El término de búsqueda no coincide con el formato solicitado.',
                    'icono' => 'error'
                ];

                return json_encode($alerta);
            }


            // Cumplido todo lo anterior, creamos la variable de SESSION['modulo_url'] y le asignamos el texto de buesqueda
            $_SESSION[$modulo_url] = $texto_busqueda;

            $alerta = [
                'tipo' => 'redireccionar',
                'url' => APP_URL . $modulo_url . '/'
            ];

            return json_encode($alerta);

            
        } catch (Exception $e) {
            $error = $e->getMessage();
            $linea = $e->getLine();

            $alerta = [
                'tipo' => 'simple',
                'titulo' => 'ERROR',
                'texto' => 'ERROR: ' . $error . 'LINE: ' . $linea . '',
                'icono' => 'error'
            ];

            return json_encode($alerta);
        }
    }




    #-- Controlador para eliminar busqueda ---
    public function eliminar_busqueda_controlador(){
        $modulo_url = $this->limpiar_cadena($_POST['modulo_url']);

        //-- verificando si el modulo existe e la lista blanca
        if( $this->modulos_busqueda_controlador($modulo_url) ){
            $alerta = [
                    'tipo' => 'simple',
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'No podemos procesar la petición en este momento.',
                    'icono' => 'error'
                ];
        }

        //-- Destruimos la variable de session que contiene el criterio de busqueda
        unset($_SESSION[$modulo_url]);

        $alerta = [
            'tipo'=>'redireccionar',
            'url' => APP_URL . $modulo_url . '/'
        ];

        return json_encode($alerta);
        
        }


}
