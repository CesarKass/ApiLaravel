<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;

class PruebasController extends Controller
{
    
    public function index(){
        // $titulo = '';

    }

    
    function testOrm(){
        // $posts = Post::all();
        // return $posts;

        // $posts = Post::all();
        // foreach($posts as $post){
        //     echo '<h1>'.$post->title.'</h1>';
        //     echo '<span>'.$post->user->name.'</span>';
        //     echo '<span>'.$post->category->name.'</span>';
        //     echo '<p>'.$post->content.'</p>';
        //     echo '<hr>';
        // }

        $Categories = Category::all();
        foreach($Categories as $category){
            echo '<h1>'.$category->name.'</h1>';
            foreach($category->posts as $post){
                echo '<h1>'.$post->title.'</h1>';
                echo '<span>'.$post->user->name.'</span>';
                echo '<span>'.$post->category->name.'</span>';
                echo '<p>'.$post->content.'</p>';
            } 
        }
        echo '<hr>';

    }
}
