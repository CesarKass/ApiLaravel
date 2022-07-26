<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthMiddleware
{ 
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token); 

        if($checkToken){
            return $next($request);
        }else{
            $data = array(
                'code' => 400,
                'status' => 'error', 
                'message' => 'El usuario no esta idenificado'
            ); 
        }

        return response()->json($data, $data['code']);
    }
}
