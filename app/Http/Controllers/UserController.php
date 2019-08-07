<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  //Para usar el objeto Auth
use Illuminate\Support\Facades\Storage; //para los discos virtuales
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class UserController extends Controller
{   

    public function __construct(){
        $this->middleware('auth'); //Para solo acceder si estas loguiado
    }


    public function config(){
        return view('user.config');
    }

    public function update(Request $resquest){
        
        //conseguir usuario identificado
       $user =  Auth::User();// si no usamos el namespace de arriba lo podemos poner asi \Auth::User() con la raya al frente
       $id = $user->id;

       //validate del formulario
       $validate = $this->validate($resquest,[
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'nick' => 'required|string|max:255|unique:users,nick,'.$id, //valida que el nick sea unico pero con la exepcion del nick que ya tenia antes por el id
        'email' => 'required|string|email|max:255|unique:users,email,'.$id  //Nota: Nunca dejar espacio en el unique porque da error
       ]);

       //recoger daots del formulario
       $name = $resquest->input('name');
       $surname = $resquest->input('surname');
       $nick= $resquest->input('nick');
       $email = $resquest->input('email');

       //Asignar nuevos valores al objeto del usuario
       $user->name = $name;
       $user->surname = $surname;
       $user->nick = $nick;
       $user->email = $email;

       //Subir archivos
       $image_path = $resquest->file('image_path'); //recoge imagen
       if ($image_path) {
        $image_path_name = time().$image_path->getClientOriginalName(); //concatena la hora para asegurar tener un nombre unico

        //Guarda en la carpeta storage (storage/app/users)
        Storage::disk('users')->put( $image_path_name,File::get($image_path)); //Nombre del archivo y despues el fichero
                                                    //extraer o copia la imagen de la carpeta temporal donde a guardado y consigue el fichero
       
        //Setea el nombre de la imagen en el objeto
        $user->image =  $image_path_name; 
       }

       //Ejecutar consulta y cambios en la bae de datos
       $user->update();
       
       return redirect()->route('config')->with(['message' => 'Usuario actualizado correctamente']); //session flash
    }
    

    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200); //Para devolver la imagen. Se ocupa Illuminate\Http\Response;
    }
}
