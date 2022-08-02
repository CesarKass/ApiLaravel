<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;

class JwtAuth {
    public $key;

    public function __construct(){
        $this->key = 'clave';
    }


    public function sigup($email, $password, $getToken = null){
        //Buscar el user con sus credenciasles
        $user = User::where([
            'email' => $email,
            'password' => $password
        ])->first();

        $sigup = false;
        if(is_object($user)){
            $sigup = true;
        }

        //generar tocken
        if($sigup){
            $tocken = array(
                'sub' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'surname' => $user->surname,
                'descripcion' => $user->descripcion,
                'image' => $user->image,
                'iat' => time(),
                 'exp' => time() * (7 * 24 *60 *60), //una semana
            );

            $jwt = JWT::encode($tocken, $this->key, 'HS256');
            $decode = JWT::decode($jwt, $this->key, ['HS256']);

            if (is_null($getToken)) {
                $data = $jwt;
            } else {
                $data = $decode;
            }
            
        }else{
            $data = array(
                "status"=> "error",
                "message"=> "Login incorrecto", 
            );
        }

        return  $data;
    }

    public function checkToken($jwt, $getIdentity = false ){
        $auth = false;
        try{
            $jwt = str_replace('"', '', $jwt);
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        }catch(\UnexpectedValueException $e){
            $auth = false; 
        }catch(\DomainException $e){
            $auth = false;
        }

        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true; 
        }else{
            $auth = false; 
        }

        if($getIdentity){
            return $decoded;
        }

        return $auth;

    }
}