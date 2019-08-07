<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        //Traer la img con paginacion
        $images = Image::orderBy('id','desc')->paginate(5); // el paginate es para paginar pero normalmente se usa ->get()
        return view('home',['images' => $images]);
    }


}
