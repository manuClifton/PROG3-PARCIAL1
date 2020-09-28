<?php

require_once './clases/fileManager.php';
//require_once './authToken.php';

    class Usuario extends fileManager{
        public $_id;
        public $_email;
        public $_tipo;
        public $_password;

        //public const string = "autos.txt";

        function __construct($email, $tipo, $password) {
            parent::__construct("usuarios.json");
            $this->_id = Usuario::cargarIdJson();
            if(!is_null($email) && is_string($email)){
                $this->_email = $email;
            }
            if(!is_null($tipo) && is_string($tipo)){
                $this->_tipo = $tipo;
            }
            if(!is_null($password) && is_string($password)){
                $this->_password = $password; 
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


        
        public function SaveUsuarioJson(){
            $retorno = false;
            if($this->guardarJson("usuarios.json",$this)){
                $retorno = true;
            }
            return $retorno;
        }


        //cargar id
        public static function cargarIdJson(){
            $retorno = "1";
            $usuarios = Usuario::leerJson("usuarios.json");
          
            if(count($usuarios) == 0){
                $retorno = "1";
            }else{
                //var_dump( $usuarios[count($usuarios)-1]->_id);
                //die();
                $id = (int)$usuarios[count($usuarios)-1]->_id;
                $id ++;
                $retorno = (string)$id;
            }      
            return $retorno;
        }


        // validar tipo
        public static function validarTipo($tipo){
            $retorno = false;
            if($tipo == 'admin' || $tipo == 'user'){
                $retorno = true;
            }
            return $retorno;
        }

        //validar email  
        public static function validarEmail($email){
            $retorno = true;
            $emailList = Usuario::leerJson("usuarios.json");
            //var_dump($asignacionList);
            //die();
            if(count($emailList) == 0){
                return $retorno;
            }

            for ($i=0; $i < count($emailList); $i++) {

               if( $emailList[$i]->_email == $email ){
                    $retorno = false;
                    break;
                }
            }
            return $retorno;
        }

        //validar usuario y contraseña
        public static function validarUsuarioJson($email, $password){
            $retorno = false;
            $usuariosList = Usuario::leerJson("usuarios.json");
                //var_dump($usuariosList);
                for ($i=0; $i < count($usuariosList); $i++) {
                   if( $usuariosList[$i]->_email == $email &&  $usuariosList[$i]->_password == $password ){
                        $retorno = true;
                        break;
                    }
                }
            return $retorno;
        }

        public static function devolverUsuario($email){
            $retorno = false;
            $emailList = Usuario::leerJson("usuarios.json");
            //var_dump($asignacionList);
            //die();
            if(count($emailList) == 0){
                return $retorno;
            }

            for ($i=0; $i < count($emailList); $i++) {

               if( $emailList[$i]->_email == $email ){
                    $retorno = new Usuario($emailList[$i]->_email, $emailList[$i]->_tipo, $emailList[$i]->_password);
                    var_dump($retorno);
                    die();
                break;
                }
            }
            return $retorno;
        }

    }//endClass