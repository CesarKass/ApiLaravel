<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Cargar clases
use App\Http\Middleware\ApiAuthMiddleware;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Rutas de users
Route::post('/registro', 'UserController@registro');
Route::post('/login', 'UserController@login');
Route::put('/user/update', 'UserController@update');
Route::post('/user/upload',  'UserController@upload')->middleware(ApiAuthMiddleware::class);
Route::get('/user/avatar/{filename}',  'UserController@getImage');
Route::get('/user/details/{id}', 'UserController@details');

//Rutas de categorias
Route::resource('/category', 'CategoryController');

//Rutas de posts
Route::resource('/post', 'PostController');
Route::post('/post/upload',  'PostController@upload');
Route::get('/post/image/{filename}',  'PostController@getImage');
Route::get('/post/category/{filename}',  'PostController@getPostByCategory');
Route::get('/post/user/{filename}',  'PostController@getPostByUser'); 