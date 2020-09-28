<?php

require_once './clases/fileManager.php';

    class Precio extends fileManager{
        public $precio_hora;
        public $precio_estadia;
        public $precio_mensual;

        function __construct($hora, $estadia, $mensual) {
            parent::__construct("precios.json");
            if(!is_null($hora) && is_string($hora)){
                $this->precio_hora = $hora;
            }
            if(!is_null($estadia) && is_string($estadia)){
                $this->precio_estadia = $estadia;
            }
            if(!is_null($mensual) && is_string($mensual)){
                $this->precio_mensual = $mensual; 
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

        
        public function SavePrecioJson(){
            $retorno = false;
            if($this->guardarJson("precios.json",$this)){
                $retorno = true;
            }
            return $retorno;
        }





        
    }//
?>