<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Comment;
use App\Like;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function like($image_id){
        //recoger datos del usuario
        $user = \Auth::User(); 

        //Condicion para verificar si ya hay un registro es decir un like de parte del usuario
        $isset_like = Like::where('user_id',$user->id)->where('image_id',$image_id)->count(); //Me trae la cantidad 

        if ($isset_like == 0) {

            $like = new Like();

            $like->user_id = $user->id;
            $like->image_id = $image_id;
            
            //Guardar
            $like->save();

            return response()->json(['like' => $like ]);

        }else{
            return response()->json(['message' => 'El like ya existe']);
        }

        
    }

    public function dislike($image_id){
         //recoger datos del usuario
        $user = \Auth::User(); 

        //Condicion para verificar si ya hay un registro es decir un like de parte del usuario
        $isset_like = Like::where('user_id',$user->id)->where('image_id',$image_id)->first(); //Me trae un unico objeto el first

        if ($isset_like) {
      
            //Eliminar like
            $isset_like->delete();

            return response()->json(['like' => $isset_like, 'message'=>'Dislike correctamente']);

        }else{
            return response()->json(['message' => 'El like no existe']);
        }
    
        
    }
}
