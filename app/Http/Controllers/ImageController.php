<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;  //Para usar el objeto Auth
use Illuminate\Support\Facades\Storage; //para los discos virtuales
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\Image;

class ImageController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); //Para solo acceder si estas loguiado
    }

    //Redirecciona a la vista para subir imagen
    public function subir(){
        return view('image.subir');
    }

    //guardar imagen
    public function save(Request $resquest){

        //validacion
        $validate = $this->validate($resquest,[
            'description' => 'required|max:400',
            'image_path' => 'required|image' //mimes:png,jpeg,jpg,gif
           ]);

        //recoger datos del formulario
        $description = $resquest->input('description');
        $image_path = $resquest->file('image_path'); //recoge imagen

        //Asignar valores al modelo
        $user = \Auth::User(); 
        $image = new Image();
        $image->user_id = $user->id;
        $image->description =  $description;

        //Subir fichero

        if ($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName(); //concatena la hora para asegurar tener un nombre unico
    
            //Guarda en la carpeta storage (storage/app/users)
            Storage::disk('images')->put( $image_path_name,File::get($image_path)); //Nombre del archivo y despues el fichero
                                                        //extraer o copia la imagen de la carpeta temporal donde a guardado y consigue el fichero
           
            //Setea el nombre de la imagen en el objeto
            $image->image_path =  $image_path_name; 
        }
        
        $image->save();

        return redirect()->route('home')->with(['message' => 'Su imagen se ha subido correctamente!']); //session flash
    }

    //traer imagenes
    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200); //Para devolver la imagen. Se ocupa Illuminate\Http\Response;
    }


    //Imagen detalle
    public function detail($id){ //Recibe id de la imagen que se quiere sacar
        $image = Image::find($id);

        return view('image.detail',[  //Redirija a una vista y manda image como variable
            'image' => $image
        ]);

    }
}
