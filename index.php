<?php

require './clases/authToken.php';
require './clases/resultado.php';
require './clases/usuario.php';
require './clases/precio.php';

require __DIR__.'/vendor/autoload.php';
require_once('./clases/authToken.php');

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO']??"";

$estado;
$msg;

switch($method){
    case'POST':
        if($path == ''){
            $estado = false;
            $msg = "PATH VACIO";
        }

        if($path == '/registro'){
            if( isset($_POST['email']) && isset($_POST['tipo']) && isset($_POST['password']) && $_POST['email'] != "" && $_POST['tipo'] != ""  && $_POST['tipo'] != "password" ){
            
                if(!Usuario::validarTipo($_POST['tipo'])){
                    $estado = false;
                    $msg = "TIPO INVALIDO. Elija de admin o user";
                }else{
                    if(!Usuario::validarEmail($_POST['email'])){
                        $estado = false;
                        $msg = "NO SE PUEDE CREAR, EMAIL EXISTENTE";
                    }else{
                        $usuario = new Usuario($_POST['email'],$_POST['tipo'],$_POST['password']);
                    // var_dump($usuario);
                        if($usuario->SaveUsuarioJson()){
                            $estado = true;
                            $msg = "El usuario se guardo correctamente";
                        }
                        else{
                            $estado = false;
                            $msg = "Ocurrio un error al guardar el usuario";
                        }
                    }
                }
            }else{
                $estado = false;
                $msg = "FALTAN DATOS";
            }
        }
        
        if($path == '/login'){
            if( isset($_POST['email']) && isset($_POST['password']) ){

                $existe = Usuario::validarUsuarioJson($_POST['email'],$_POST['password']);

                if($existe){

                    $user =  Usuario::devolverUsuario($_POST['email']);
                    if($user != null){
                       $token = JsonWT::generarJWT($user->_email, $user->_tipo);
                        echo $token;
                        $estado = true;
                        $msg = "LOGIN CORRECTO";
                    }
                   
                }else{
                    $estado = false;
                    $msg = "ERROR EN LOGIN, verifar email o password";
                }
            }
        }
            ////

            if($path == '/precio' || $path == '/ingreso'){
                if(!JsonWT::leerToken($_SERVER['HTTP_TOKEN'])){
                    $estado = false;
                    $msg = "ERROR DE AUTENTICACION";
                }else{
                   if($path == '/precio'){
                        if( isset($_POST['precio_hora']) && isset($_POST['precio_estadia']) && isset($_POST['precio_mensual'])  ){

                          $decode =  JsonWT::leerPayload($_SERVER['HTTP_TOKEN']);

                            if($decode->tipo == 'admin'){
                                $precio = new Precio($_POST['precio_hora'],$_POST['precio_estadia'],$_POST['precio_mensual']);
                                //var_dump($precio);
                                //die();
                                if($precio->SavePrecioJson()){
                                    //echo "La materia se guardo correctamente";
                                    $estado = true;
                                    $msg = "La materia se guardo correctamente";
                                }
                                else{
                                // echo "Ocurrio un error al guardar la Materia";
                                    $estado = false;
                                    $msg = "Ocurrio un error al guardar la Materia";
                                }
                            }else{
                                $estado = false;
                                $msg = "NO ES ADMIN";
                            }
                            
                        }
                        else{
                            $estado = false;
                            $msg = "FALTAN DATOS DEL PRECIO";
                        }
                    }
                }
            }


            ///////
    break;

    case'GET':
        echo "toavia no lo hice";
    break;

    default:
        $estado = false;
        $msg = "METODO INVALIDO";
    break;
}


fileManager::mostrarResultado($estado, $msg);


?>