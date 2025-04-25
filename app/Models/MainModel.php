<?php 

namespace app\Models;
use \PDO;

if( file_exists( __DIR__ . '/../../config/server.php' ) ){
    require_once( __DIR__ . '/../../config/server.php' );
}

class MainModel {

    private $server = DB_SERVER;
    private $database = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;

    protected function conectar(){
        $conexion = new PDO("mysql:host=".$this->server . ";dbname=". $this->database , $this->user , $this->pass);
        $conexion->exec('SET CHARACTER SET utf8');
        return $conexion;
    }
     

    protected function ejecutar_consulta( $sql ){
        $query = $this->conectar()->prepare($sql);
        $query->execute();
        return $query;
    }

    public function limpiar_cadena( $cadena ){
        $palabras = [ '<script>',
                      '</script>',
                      '<script src>',
                      '<script type=>',
                      'SELECT * FROM',
                      'DELETE FROM',
                      'INSERT INTO',
                      'DROP TABLE',
                      'DROP DATABASE',
                      'TRUNCATE TABLE',
                      'SHOW TABLE',
                      'SHOW DATABASE',
                      '<?php',
                      '?>',
                      '--','<','>','[',']','^','','==','===',';','::'];

            $cadena = trim($cadena);
            $cadena = stripslashes($cadena);        
            
            foreach( $palabras as $palabra){
                $cadena = str_ireplace($palabra,'',$cadena);
            }
            
            $cadena = trim($cadena);
            $cadena = stripslashes($cadena); 

            return $cadena;                 


    }

    protected function verificar_datos($filtro, $cadena){
        if( preg_match( "/^" . $filtro . "$/", $cadena ) ){
            //no hay problema (cumple con el patron)
            return false; 

        }else{
            //No cumple con el patron
            return true;
        }

    }


    //CRUD
    protected function guardar_datos($tabla, $datos){
        
        $sql = "INSERT INTO $tabla (";

        $contador = 0;
        foreach( $datos as $clave ){
            if($contador >=1)
                { $sql .=","; }
            $sql .= $clave["campo_nombre"];
            $contador++;    
        }

        $sql.=") VALUES(";

        $contador=0;
        foreach($datos as $clave){
            if( $contador >= 1  ) {  $sql .=","; }
            $sql .= $clave["campo_marcador"];
            $contador++;
        }

        $sql .= ");";

        $query = $this->conectar()->prepare($sql);

        foreach($datos as $clave){
            $query->bindParam($clave["campo_marcador"], $clave["campo_valor"] ); 
        }

        
        $query->execute();

        return $query;

    }


    public function seleccionar_datos($tipo, $tabla, $campo, $id ){
        $tipo = $this->limpiar_cadena($tipo);
        $tabla = $this->limpiar_cadena($tabla);
        $campo = $this->limpiar_cadena($campo);
        $id = $this->limpiar_cadena($id);

        if( $tipo == 'unico'){
            $sql = "SELECT * FROM $tabla WHERE $campo =:ID;";
            $query = $this->conectar()->prepare($sql);
            $query->bindParam(":ID", $id);
        
        }elseif($tipo == "normal"){
            $sql = "SELECT $campo FROM $tabla";
            $query = $this->conectar()->prepare($sql);
        }
        
        $query->execute();
        return $query;
    }


    protected function actualizar_datos($tabla, $datos, $condicion){
        
        $sql = "UPDATE $tabla SET ";

        $contador=0;
        foreach( $datos as $clave ){

            if($contador >= 1) { $sql .=', '; };
            $sql .= $clave["campo_nombre"] . " = " . $clave["campo_marcador"];
            $contador++;
        }

        $sql .= " WHERE " . $condicion["condicion_campo"] . " = " . $condicion["condicion_marcador"] . ";";
        
        $query = $this->conectar()->prepare($sql);

        foreach($datos as $clave){
            $query->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
        }

        $query->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);

        $query->execute();
       
        return $query;
    }

    protected function eliminar_registro($tabla, $campo, $id){
        $sql = "DELETE FROM $tabla WHERE $campo = :ID";
        $sentencia = $this->conectar()->prepare($sql);
        $sentencia->bindParam(":ID", $id);
        $sentencia->execute();
        return $sentencia;



    }


    //Paginación
    protected function paginador_tablas($pagina, $numeroPaginas, $url, $numeroBotones ){
        
         $tabla = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination" >';

         if($pagina <= 1){
            $tabla .= ' <a class="pagination-previous is-disabled" disabled >Anterior</a>';
            $tabla .= ' <ul class="pagination-list">';
            
        }else{
            $tabla .= '<a class="pagination-previous" href="'. $url . ($pagina - 1) . '/' . '">Anterior</a>';
            $tabla .= '<ul class="pagination-list">';
            $tabla .= '<li>';
            $tabla .= '<a class="pagination-link" href=" ' . $url .'">1</a>';
            $tabla .= '</li>';

            $tabla .= '<li>';
            $tabla .= '<span class="pagination-ellipsis">&hellip;</span>';   //boton de los tres puntitos
            $tabla .= '</li>';

         }

         //botones centrales
         $contador= 0;
         for($i = $pagina; $i <= $numeroPaginas; $i++ ){
            
                if( $contador >= $numeroBotones ){
                    break;
                }
 
                //boton de pagina actual coloreado
                if( $pagina == $i ){
                    $tabla .= '<li>';    
                    $tabla .= '<a class="pagination-link is-current" href="' . $url . $i . '/" >' . $i . '</a>';    
                    $tabla .= '</li>';   
                    
                }else{
                    // botones a otras paginas
                    $tabla .= '<li>';    
                    $tabla .= '<a class="pagination-link" href="' . $url . $i . '/" >' . $i . '</a>';    
                    $tabla .= '</li>';    
                }

                $contador++;
         }


         //botones de la derecha

         if($pagina == $numeroPaginas){

            $tabla .= '</ul>'; //cierra la lista de los botones centrales
            $tabla .= '<a class="pagination-next is-disabled" disabled>Siguiente</a>';
            
        }else{

            $tabla .= '<li>';
            $tabla .= '<span class="pagination-ellipsis">&hellip;</span>';  //boton de los tres puntitos
            $tabla .= '</li>';

            $tabla .= '<li>';
            $tabla .= '<a class="pagination-link" href=" ' . $url . $numeroPaginas . '/' . '">' . $numeroPaginas  . '</a>';
            $tabla .= '</li>';



             $tabla .= '</ul>'; //cierra la lista de los botones centrales
             $tabla .= '<a class="pagination-next" href="' . $url . ($pagina + 1) . '/" >Siguiente</a>';   //no esta desabilitado por que no estamos en la ultima pagina
          
         }

         $tabla .= '</nav>';

         return $tabla;

    }




   


}