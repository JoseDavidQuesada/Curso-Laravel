<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images'; //Tabla de la base de datos

    //Relacion one to many. 
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id','desc'); //Orber by para traer los comments del mas nuevo al mas viejo
    }

    //Relacion one to many.
    public function likes(){
        return $this->hasMany('App\Like'); //Metodo lo que hace es traerme todos los likes relacionados con el id de img.
    }

    //Relacion many to one.
    public function user(){
        return $this->belongsTo('App\User','user_id'); //Metodo lo que hace es traer todas las img relacionadas con el id del user.
        //belongsTo recibe dos parametros la rutas del modelo y la foreing key de la tabla relacionada para estar seguros.
    }
}
