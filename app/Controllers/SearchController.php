<?php 

namespace app\Controllers;

use app\Models\MainModel;


class SearchController extends MainModel {

    # -- Controlador modulos de busqueda --
    public function modulos_busqueda_controlador($modulo){
        $lista_modulos = ['userSearch'];

        if( in_array( $modulo, $lista_modulos ) ){
            return false;
        }else{
            return true;
        }
    } 

    
}



