<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use App\Category;

class PostController extends Controller
{
     public function __construct(){
        $this->middleware('api.auth', ['except'=> ['index','show','getImage', 'getPostByUser','getPostByCategory']]);
    }

    public function index(){//get
        $posts = Post::all()->load('category');
        return response()->json([
            "code"=> 200,
            "status" => "success",
            "posts" => $posts
        ]);
    }

    public function show($id){//get/id
        $Post = Post::find($id)->load('category');
         if(is_object($Post)){
            $data = [
                "code"=> 200,
                "status" => "success",
                "post" => $Post
            ];
         }else{
            $data = [
                "code"=> 400,
                "status" => "error"
            ];
         }

         return response()->json($data, $data['code']); 
    }

    public function store(Request $request){//post/jsonData

        $jsonData = $request->input('json', null);  
        $params  = json_decode($jsonData );               //objeto
        $paramsArray = json_decode($jsonData, true);      //array


        if(!empty($params) && !empty($paramsArray)){
            $paramsArray = array_map('trim', $paramsArray);

            $jwtAuth = new \JwtAuth();
            $token = $request->header('Authorization', null);
            $user = $jwtAuth->checkToken($token, true);

            $validateData = \Validator::make($paramsArray, [
                'title' => 'required',
                'content' => 'required',
                'image' => 'required',
                'category_id' => 'required'
            ]);
            
            if($validateData->fails()){
                $data = array(
                    'status' => 'error', 
                    'message' => 'Algo va mal', 
                    'code' => 400,
                    'error' => $validateData->errors()
                ); 
                
            }else{
                 
                $Post = new Post();
                $Post->user_id  = $user->sub;  
                $Post->category_id  = $params->category_id;  
                $Post->title  = $params->title;  
                $Post->content  = $params->content;  
                $Post->image  = $params->image;  
                $Post->save(); 

                $data = array(
                    'status' => 'success', 
                    'message' => 'Registro correcto', 
                    'code' => 200,
                    'post' => $Post, 
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

    public function update(Request $request, $id){//put/jsonData

        $jsonData = $request->input('json', null);  
        $params  = json_decode($jsonData );           //objeto
        $paramsArray = json_decode($jsonData, true);      //array
        
        if(!empty($params) && !empty($paramsArray)){

            // $paramsArray = array_map('trim', $paramsArray);
            
            $validateData = \Validator::make($paramsArray, [ 
                'category_id' => 'required',
                'title' => 'required',
                'content' => 'required',
                'image' => 'required'
            ]);
            if($validateData->fails()){
                $data = array(
                    'status' => 'error', 
                    'message' => 'Algo va mal', 
                    'code' => 400,
                    'error' => $validateData->errors()
                ); 
                
            }else{
                 
                unset($paramsArray['id']);
                unset($paramsArray['user_id']);
                unset($paramsArray['category']);
                unset($paramsArray['created_at']);
    
                $post_update = Post::where('id', $id)->update($paramsArray);

                $data = array(
                    'status' => 'success', 
                    'message' => 'Modificación correcta', 
                    'code' => 200,
                    'post' => $post_update, 
                    'changes' => $paramsArray, 
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

    public function destroy(Request $request, $id){

        //Usuario identificado
        $jwtAuth = new \JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);
        //Buscar elemento, validar existencia y eliminar 
        // $Post = Post::find($id)->where('user_id', $user->sub)->first();
        $Post = Post::where('id', '=', $id);
        
        if(!empty($Post)){
            $Post->delete();
            $data = [
                "code"=> 200,
                "status" => "success",
                "post" => $Post
            ];
        }else{
            $data = [
                "code"=> 400,
                "status" => "error",
                "message" => "No existe el elemento"
            ];
        }
       
        return response()->json($data, $data['code']); 

    }

    public function upload(Request $request){
        $img = $request->file('file0');

        $validateData = \Validator::make($request->all(), [ 
            'file0' => 'required|image|mimes:jpg,jpeg,png,gif', 
        ]);
        
        if($validateData->fails() || !$img){
            $data = array(
                'status' => 'error', 
                'message' => 'Algo va mal', 
                'code' => 400,
                'error' => $validateData->errors()
            );  
        }else{
            $image_name = time().$img->getClientOriginalName();
            \Storage::disk('images')->put($image_name, \File::get($img));
            $data = array(
                'status' => 'success',  
                'code' => 200, 
                'image' => $image_name
            ); 
        }

        return response()->json($data, $data['code']); 
    }

    public function getImage($filename){
        $isset = \Storage::disk('images')->exists($filename);
        if ($isset) {
            $file = \Storage::disk('images')->get($filename);
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

    public function getPostByCategory($id){
        $post = Post::where('category_id', $id)->get();

        return response()->json([
            "status" => "success",
            "post" => $post
        ], 200);
    }

    public function getPostByUser($id){
        $post = Post::where('user_id', $id)->get();

        return response()->json([
            "status" => "success",
            "post" => $post
        ], 200);
    }

}
