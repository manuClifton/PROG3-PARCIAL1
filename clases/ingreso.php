<?php

require_once './clases/fileManager.php';

    class Ingreso extends fileManager{
        public $patente;
        public $fecha_ingreso;
        public $tipo;

        function __construct($patente, $fecha_ingreso, $tipo) {
            parent::__construct("autos.json");
            if(!is_null($patente) && is_string($patente)){
                $this->patente = $patente;
            }
            if(!is_null($fecha_ingreso) && is_string($fecha_ingreso)){
                $this->fecha_ingreso = $fecha_ingreso;
            }
            if(!is_null($tipo) && is_string($tipo)){
                $this->tipo = $tipo;
            }
        }

        public function __set($name, $value)
        {
            $this->$name = $value;
        }

        public function __get($name)
        {
            return $this->$name;
        }


        public function __toString(){

            return json_encode($this);
        }

        
        public function SaveIngresoJson(){
            $retorno = false;
            if($this->guardarJson("autos.json",$this)){
                $retorno = true;
            }
            return $retorno;
        }

        public static function validarTipo($tipo){
            $retorno = false;
            if($tipo == 'hora' || $tipo == 'estadia' || $tipo == 'mensual'){
                $retorno = true;
            }
            return $retorno;
        }

        public static function devolverIngreso($patente){
            $retorno = null;
            $list = Ingreso::leerJson("autos.json");
            //var_dump($asignacionList);
            //die();
            if(count($list) == 0){
                return $retorno;
            }

            for ($i=0; $i < count($list); $i++) {

               if( $list[$i]->patente == $patente ){
                    $retorno = new Ingreso($list[$i]->patente, $list[$i]->fecha_ingreso, $list[$i]->tipo);
                    //var_dump($retorno);
                    //die();
                break;
                }
            }
            return $retorno;
        }

        
    }//
?>