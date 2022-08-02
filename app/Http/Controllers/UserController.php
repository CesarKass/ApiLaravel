<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\User;

class UserController extends Controller
{
    public function registro (Request $request){
        $jsonData = $request->input('json', null);  
        $params  = json_decode($jsonData );           //objeto
        $paramsArray = json_decode($jsonData, true);      //array
        
        $validateData = \Validator::make($paramsArray, [
            'name' => 'required|alpha',
            'surname' => 'required|alpha',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if(!empty($params) && !empty($paramsArray)){
            $paramsArray = array_map('trim', $paramsArray);
            
            if($validateData->fails()){
                $data = array(
                    'status' => 'error', 
                    'message' => 'Algo paso', 
                    'code' => 400,
                    'error' => $validateData->errors()
                ); 
                
            }else{
                //Cifrar contraseña y cifrar contraseña 4 veces
                // $pwd = password_hash($params->password, PASSWORD_BCRYPT,['cost'=> 4]);
                $pwd = hash('sha256', $params->password);
                
                $user = new User();
                $user->name  = $paramsArray['name'];
                $user->surname  = $paramsArray['surname'];
                $user->email  = $paramsArray['email'];
                $user->password  = $pwd;
                $user->role  = 2;

                $user->save(); 

                $data = array(
                    'status' => 'success', 
                    'message' => 'Registro correcto', 
                    'code' => 200,
                    'user' => $user, 
                ); 
            } 
    
        }else{
            $data = array(
                'status' => 'error',
                'message' => 'Los datos enviados no son correctos',
                'code' => 400
            ); 
        }

        return response()->json($data, $data['code']);
 
    }

    public function login(Request $request){
        $jsonData = $request->input('json', null);  
        $params  = json_decode($jsonData );           //objeto
        $paramsArray = json_decode($jsonData, true);      //array
        
        $validateData = \Validator::make($paramsArray, [ 
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validateData->fails()){
            $data = array(
                'status' => 'error', 
                'message' => 'El usuario no se puede logear', 
                'code' => 400,
                'error' => $validateData->errors()
            );  
        }else{
            $jwtAuth = new \JwtAuth();
            $pwd = hash('sha256', $params->password);
            
            $data = $jwtAuth->sigup($params->email, $pwd);  
            
            if(!empty($params->gettoken)){
                $data = $jwtAuth->sigup($params->email, $pwd, true);  
            }
        }  
        return response()->json( $data, 200 );

    }

    public function update(Request $request){ 

        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);

        $jsonData = $request->input('json', null); 
        $paramsArray = json_decode($jsonData, true);        //array

        if($checkToken && !empty($paramsArray)){

            $user = $jwtAuth->checkToken($token, true);
            
            $validateData = \Validator::make(
                $paramsArray, 
                [
                    'name' => 'required|alpha',
                    'surname' => 'required|alpha',
                    'email' => 'required|email|unique:users,'.$user->sub //validar email exepto el email del user logeado
                ]
            );

            // $arrUpdate = array(
            //     'name' => $paramsArray['name'],
            //     'surname' => $paramsArray['surname'],
            //     'email' => $paramsArray['email']
            // );
            unset($paramsArray['id']);
            unset($paramsArray['role']);
            unset($paramsArray['password']);
            unset($paramsArray['created_at']);
            unset($paramsArray['updated_at']); 

            $user_update = User::where('id', $user->sub)->update($paramsArray);

            $data = array(
                'status' => 'succes', 
                'message' => 'El usuario fue modificado', 
                'code' => 200,
                'user' => $user,
                'changes' => $paramsArray
            ); 

        }else{
            $data = array(
                'status' => 'error', 
                'message' => 'El usuario no esta idenificado', 
                'code' => 400
            ); 
        }

        return response()->json($data, $data['code']);
    }

    public function upload(Request $request){ 

        $image = $request->file('file0');

        $validateData = \Validator::make($request->all(), [
            "file0" => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        if(!$image || $validateData->fails()){
            $data = array(
                'status' => 'error',
                'message' => 'No se pudo subir la imagen',
                'code' => 400,
                'error' => $validateData->errors()
            );
        }else{
            $image_name = time().$image->getClientOriginalName();
            \Storage::disk('users')->put($image_name, \File::get($image));

            $data = array(
                'code' => 200,
                'status' => 'succes',
                'image' => $image_name
            );
        }  


        // return response()->json($data, $data['code'])->header('Content-Type', 'text/plain');
        return response()->json($data, $data['code']);
    }

    public function getImage($filename){

        $isset = \Storage::disk('users')->exists($filename);
        if ($isset) {
            $file = \Storage::disk('users')->get($filename);
            return new Response($file, 200);
        }else{
            $data = array(
                'status' => 'error',
                'message' => 'Imagen no existe',
                'code' => 400 
            );
            return response()->json($data, $data['code']);
        }

    }

    public function details($id){
        
        $user = User::find($id);

        if(is_object($user)){
            $data = array(
                'status' => 'success', 
                'code' => 200,
                'user'=> $user
            );
        }else{
            $data = array(
                'status' => 'error',
                'message' => 'El usuario no existe',
                'code' => 400
            );
        }

        return response()->json($data, $data['code']);
    }

}
