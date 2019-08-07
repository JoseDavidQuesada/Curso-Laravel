@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('include.message') <!--Incluede del message -->

            

                <div class="card pub_image"> <!--Estilo extra para el avatar del card -->
                        <div class="card-header">
                           
                                <div class="container-avatar">
                                    <img src="{{ asset('img/avatar.jpg') }}" class="avatar" /> <!-- Envia el parametro de img a la ruta -->
                                </div>
                        
                            <div class="data-user">
                                 Jose David Quesada | <!-- Agregar -->
                                 <span class="nickname">
                                    @JoseDavidQ <!-- Agregar -->
                                 </span>
                            </div>
                            
                        </div>
        
                        <div class="card-body">
                            <a href="{{ route('image.detail') }}"> <!--Ruta para el controlador de detalle -->
                                <div class="image-container">
                                    <img src="{{ asset('img/avatar.jpg') }}" alt=""> <!--Agregar imagen normal -->
                                </div>
                            </a>
                            <div class="description">
                                <span class="nickname"> @JoseDavidQ <!-- Agregar --></span> <!--nickname -->
                                <span class="nickname">  | hace 22 horas <!-- Agregar helper --> </span> <!-- Utilizando el helper que creamos. -->
                                
                                <p>Hola como estas?</p><!--Descripcion -->
                            </div>

                            <div class="likes">

                                <!-- valida si es true y le asigna su respectiva imagen black o red -->
                                
                                <img src="{{asset('img/heart-red.png')}}" data-info="idImagen" class="btn-dislike"/>
                                

                                <p> 15 <!-- Agregar count --></p>
                                
                            </div>

                            <div class="comments">
                                <a href="" class="btn btn-sm btn-warning btn-comments">Comentarios (15) <!-- Agregar --></a>
                            </div>
                        </div>
                    </div>
                
            

            
            <div class="clearfix"></div>

        </div>
    </div>
</div>
@endsection
