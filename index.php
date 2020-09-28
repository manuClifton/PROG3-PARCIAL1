<?php

require './clases/authToken.php';
require './clases/resultado.php';
require './clases/usuario.php';

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
                    die();
                   //$token = JsonWT::generarJWT($user->_email, $user->_tipo);
                   echo $token;
                    $estado = true;
                    $msg = "LOGIN CORRECTO";
                }else{
                    $estado = false;
                    $msg = "ERROR EN LOGIN, verifar email o password";
                }
            }
        }
            ////

            if($path == '/precio' || $path == '/ingreso'){
                if(!JsonWT::leerToken($_SERVER['HTTP_TOKEN'])){
                    //echo "FALTA TOKEN";
                    $estado = false;
                    $msg = "ERROR DE AUTENTICACION";
                }else{
                 /*  if($path == '/materia'){
                        if( isset($_POST['nombre']) && isset($_POST['cuatrimestre']) ){
                            $materia = new Materia($_POST['nombre'],$_POST['cuatrimestre']);
                            //var_dump($materia);
                            //die();
                            if($materia->SaveMateriaJson()){
                                //echo "La materia se guardo correctamente";
                                $estado = true;
                                $msg = "La materia se guardo correctamente";
                            }
                            else{
                               // echo "Ocurrio un error al guardar la Materia";
                                $estado = false;
                                $msg = "Ocurrio un error al guardar la Materia";
                            }
                        }
                        else{
                            //echo "FALTAN DATOS DE LA MATERIA";
                            $estado = false;
                            $msg = "FALTAN DATOS DE LA MATERIA";
                        }
                    }
    
                    if($path == '/profesor'){
                        if(isset($_POST['nombre']) && isset($_POST['legajo'])){
        
                            if(!Profesor::validarProfesorJson($_POST['legajo'])){
                                //echo "YA EXISTE EL LEGAJO";
                                //die();
                                $estado = false;
                                $msg = "YA EXISTE EL LEGAJO";
                            }else{
                                $profesor = new Profesor($_POST['nombre'],$_POST['legajo']);
                            
                                //var_dump($profesor);
                                //die();
                                if($profesor->SaveProfesorJson()){
                                    //echo "El Profesor se guardo correctamente";
                                    $estado = false;
                                    $msg = "El Profesor se guardo correctamente";
                                }
                                else{
                                    //echo "Ocurrio un error al guardar el Profesor";
                                    $estado = false;
                                    $msg = "Ocurrio un error al guardar el Profesor";
                                }
                            }
                        
                            
                        }else{
                           // echo "FALTAN DATOS DEL PROFESOR";
                            $estado = false;
                            $msg = "FALTAN DATOS DEL PROFESOR";
                        }
                    }
    
                    if($path == '/asignacion'){
                        if(isset($_POST['legajo']) && isset($_POST['idMateria']) && isset($_POST['turno']) ){
        
                            if(!Asignacion::validarTurno($_POST['turno'])){
                                //echo "TURNO INVALIDO";
                                $estado = false;
                                $msg = "TURNO INVALIDO. Elija de mañana o tarde";
                            }else{
                                if(!Asignacion::validarAsignacionJson($_POST['legajo'],$_POST['turno'])){
                                    // echo "NO SE PUEDE ASIGNAR";
                                     $estado = false;
                                     $msg = "NO SE PUEDE ASIGNAR, REVISAR LEGAJO Y TURNO";
                                 }else{
                                    $asignacion = new Asignacion($_POST['legajo'],$_POST['idMateria'],$_POST['turno']);
                                    //var_dump($asignacion);
                                    if($asignacion->SaveAsignacionJson()){
                                        //echo "La Asignación se guardo correctamente";
                                        $estado = true;
                                        $msg = "La Asignación se guardo correctamente";
                                    }
                                    else{
                                        //echo "Ocurrio un error al guardar la Asignación";
                                        $estado = false;
                                        $msg = "Ocurrio un error al guardar la Asignación";
                                    }
                                 }
                            }
                        }else{
                            //echo "FALTAN DATOS DEL PROFESOR";
                            $estado = false;
                            $msg = "FALTAN DATOS DEL PROFESOR";
                        } 
                    }*/
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