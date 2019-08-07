@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('include.message') <!--Incluede del message -->

                <div class="card pub_image pub_image_detail"> <!--Estilo extra para los comentarios del card -->
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


                            <div class="clearfix"></div> <!-- Limpiar flotados -->

                            <div class="comments">
                                <h2>Comentarios (15)</h2>
                                <hr>

                                <form action=" " method="post">
                                    @csrf <!--Seguridad al formulario -->

                                    <input type="hidden" name="image_id" value="ImageId">
                                    <p>
                                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" required></textarea>
                                            @error('content"')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </p>
                                    <button type="submit" class="btn btn-success"> Comentar</button>

                                </form>

                                <hr>
                            
                                    
                                
                                <div class="comment">
                                        <span class="nickname"> @Pedrito</span>
                                        <span class="nickname"> | hace 3 horas</span> <!-- Utilizando el helper que creamos. -->
                                        
                                        <div class="col-lg-12">
                                            <div class="col-lg-10" style="float: left;">
                                                <p>Me encanto</p>
                                            </div>

                                             <!--Validar cuando podra eliminar -->
                                                
                                                <div class="col-lg-2 text-right" style="float: left;">
                                                    <a href="">Eliminar</a>
                                                </div>

                                           
                                            
                                        </div>

                                        <div class="clearfix"></div>
                                      
                                </div>

                                
                            </div>
                        </div>
                    </div>
                

        </div>
    </div>
</div>
@endsection