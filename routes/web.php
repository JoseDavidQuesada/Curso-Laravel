<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

//Only view
Route::get('/home',function () {
    return view('home');
})->name('home');

Route::get('/configuracion',function () {
    return view('user.config');
})->name('config');


Route::get('/subir-imagen',function () {
    return view('image.subir');
})->name('image.subir');

Route::get('/image/detail',function () {
    return view('image.detail');
})->name('image.detail');


/*
// Perfil Usuario
Route::get('/configuracion', 'UserController@config')->name('config');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');

//Subir imagenes
Route::get('/subir-imagen', 'ImageController@subir')->name('image.subir');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');

//Ver imagenes
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/image/{id}', 'ImageController@detail')->name('image.detail');

//Comentarios
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

//Like
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');

*/