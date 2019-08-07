<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Console\Migrations\ResetCommand;
use Illuminate\Support\Facades\Auth;  //Para usar el objeto Auth
use Illuminate\Http\Response;
use App\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Guarda los comentarios
    public function save(Request $request)
    {  
       $user = \Auth::User();  
       $image_id =  $request->input('image_id'); 
       $content = $request->input('content');

       $comment = new Comment();
       
       $comment->user_id = $user->id;
       $comment->image_id = $image_id;
       $comment->content = $content;

       $comment->save();

       return redirect()->route('image.detail',['id' => $image_id])->with(['message' => 'Su comentario se ha subido correctamente!']); //session flash
    
    }

    public function delete($id)
    {   
        //conseguir datos del usuario logueado
        $user = \Auth::User(); 

        //Conseguir objeto del comentario
        $comment = Comment::find($id);

        //Comprobar si el dueno del comentario o de la imagen

        if ($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id )) {
            $comment->delete();

            return redirect()->route('image.detail',['id' => $comment->image->id])->with(['message' => 'El comentario se borro correctamente!']); //session flash
        }else{
            return redirect()->route('image.detail',['id' =>$comment->image->id])->with(['message' => 'El comentario no se pudo borrar']); //session flash
        }


    }
}
