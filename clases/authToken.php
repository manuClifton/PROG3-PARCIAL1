<?php

use \Firebase\JWT\JWT;

   class JsonWT{

      public static function generarJWT($email, $tipo){
         $Key = "primerparcial";
         $payload = array(   
             "email" => $email,
             "tipo" => $tipo
         );
         return $jwt = JWT::encode($payload,$Key);
      }

      public static function leerToken($token)
      {
         $Key = "example_key";
         try {
            $decode = JWT::decode($token,$Key,array('HS256'));
            return true;
         } catch (Throwable $th) {
            return false;
         }

      }
   
   }//
?>