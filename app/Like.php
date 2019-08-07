<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes'; //Tabla de la base de datos

    //Relacion many to one.
    public function user(){
        return $this->belongsTo('App\User','user_id'); //Metodo lo que hace es traer los likes relacionados con el id del user.
        //belongsTo recibe dos parametros la rutas del modelo y la foreing key de la tabla relacionada para estar seguros.
    }

    //Relacion many to one.
    public function image(){
        return $this->belongsTo('App\Image','image_id'); //Metodo lo que hace es traer los likes relacionados con el id de la img.
        //belongsTo recibe dos parametros la rutas del modelo y la foreing key de la tabla relacionada para estar seguros.
    }
}
