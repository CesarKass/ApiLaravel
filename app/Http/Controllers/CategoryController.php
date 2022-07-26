<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Category;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('api.auth', ['except'=> ['index','show']]);
    }

    public function index(){
        $categories = Category::all();
        return response()->json([
            "code"=> 200,
            "status" => "success",
            "categories" => $categories
        ]);
    }

    public function show($id){
        $category = Category::find($id);
         if(is_object($category)){
            $data = [
                "code"=> 200,
                "status" => "success",
                "categories" => $category
            ];
         }else{
            $data = [
                "code"=> 400,
                "status" => "error"
            ];
         }

         return response()->json($data, $data['code']); 
    }

    public function store(Request $request){

        $jsonData = $request->input('json', null);  
        $params  = json_decode($jsonData );           //objeto
        $paramsArray = json_decode($jsonData, true);      //array
        
        $validateData = \Validator::make($paramsArray, [
            'name' => 'required', 
        ]);

        if(!empty($params) && !empty($paramsArray)){
            $paramsArray = array_map('trim', $paramsArray);
            
            if($validateData->fails()){
                $data = array(
                    'status' => 'error', 
                    'message' => 'Algo va mal', 
                    'code' => 400,
                    'error' => $validateData->errors()
                ); 
                
            }else{
                 
                $category = new Category();
                $category->name  = $paramsArray['name'];  
                $category->save(); 

                $data = array(
                    'status' => 'success', 
                    'message' => 'Registro correcto', 
                    'code' => 200,
                    'user' => $category, 
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

    public function update(Request $request, $id){

        $jsonData = $request->input('json', null);  
        $params  = json_decode($jsonData );           //objeto
        $paramsArray = json_decode($jsonData, true);      //array
        
        $validateData = \Validator::make($paramsArray, [
            'name' => 'required', 
        ]);

        if(!empty($params) && !empty($paramsArray)){
            $paramsArray = array_map('trim', $paramsArray);
            
            if($validateData->fails()){
                $data = array(
                    'status' => 'error', 
                    'message' => 'Algo va mal', 
                    'code' => 400,
                    'error' => $validateData->errors()
                ); 
                
            }else{
                 
                unset($paramsArray['id']);  
                unset($paramsArray['created_at']); 
    
                $category_update = Category::where('id', $id)->update($paramsArray);

                $data = array(
                    'status' => 'success', 
                    'message' => 'Registro correcto', 
                    'code' => 200,
                    'category' => $paramsArray, 
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

}
