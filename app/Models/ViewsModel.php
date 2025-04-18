<?php

namespace app\Models;

class ViewsModel {

    protected function obtenerVistasModelo($vista){
        $lista_blanca = ['dashboard','test','userNew','userList','userSearch','userUpdate','userPhoto','logOut'];

        if( in_array( $vista, $lista_blanca ) ){
            if( is_file( './app/views/content/' . $vista . '-view.php' ) ){
                $contenido = './app/views/content/' . $vista . '-view.php';
            }else{
                $contenido = '404';
            }

        }elseif( $vista == 'login' || $vista == 'index' ){
            $contenido = 'login';

        }else{
            $contenido = '404'; 
        }

        return $contenido;

    }


}