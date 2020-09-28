<?php

    class Resultado{
        public $_estado;
        public $_msg;

        public function __construct($estado,$msg)
        {   
            $this->_estado = $estado;
            $this->_msg = $msg;
        }

        public function __set($name, $value)
        {
            $this->$name = $value;
        }

        public function __get($name)
        {
            return $this->$name;
        }

        public function mostarRespuesta(){
            echo json_encode($this);
        }
    }

?>