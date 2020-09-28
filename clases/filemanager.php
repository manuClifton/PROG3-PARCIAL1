<?php

require_once './clases/resultado.php';

    class fileManager {

        public $_filename;

        public function __construct($name) {
            $this->filename = $name;
        }

       public static function leerJson($filename){

            $archivo = fopen($filename, "r");
            if($archivo){
                $fread = fread($archivo, filesize($filename) );
                $arrayJson = json_decode($fread);
            }
            else{
                echo "EL ARCHIVO NO EXISTE";
            }
            if($archivo){
                $archivo = fclose($archivo);
            }
            return $arrayJson;
       }

       public static function guardarJson($filename, $objeto){
           $arrayJson = fileManager::leerJson($filename);
            
           if(!is_null($arrayJson)){
            
                array_push($arrayJson, $objeto);
               // var_dump($arrayJson);
                //die();
                $archivo = fopen($filename, "w");

                if($archivo){
                   // echo $archivo;
                    //die();
                    $fwrite = fwrite($archivo, json_encode($arrayJson,JSON_PRETTY_PRINT));

                    fclose($archivo);
                    return true;
                }
           }

           return false;
       }

        public static function mostrarResultado($estado, $msg){

            if($msg == []){
                $msg = "AUN NO SE DIO DE ALTA NINGUNA ENTIDAD DE LA QUE INTENTA MOSTRAR";
            }
            $respuesta = new Resultado($estado, $msg);

            echo json_encode($respuesta);
        }


    }//end class