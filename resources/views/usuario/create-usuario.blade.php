<!DOCTYPE html>
<html>
<head>
    <title>Home - Registro</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/usuarios/create-user-pc.css') }}"/>
</head>
<body>
    <section>
        <ul id="carrousel">
            <li class="liCarrousel"><img src="{{ asset('photos/pc/HOME-FUTBOL.jpg') }}"></li>
            <li class="liCarrousel"><img src="{{ asset('photos/pc/HOME-BALONCESTO.jpg') }}"></li>
            <li class="liCarrousel"><img src="{{ asset('photos/pc/HOME-TENIS.jpg') }}"></li>
            <li class="liCarrousel"><img src="{{ asset('photos/pc/HOME-BADMINTON.jpg') }}"></li>
            <li class="liCarrousel"><img src="{{ asset('photos/pc/HOME-FUTBOL.jpg') }}"></li>
        </ul>
        <div id="agruparPortada">
            <header> LIGAS DEPORTIVAS DE RECREO </header>
            <h3>INSTITUTO PABLO SERRANO</h3>
            <form action="{{ url('/usuario') }}" method="post" enctype="multipart/form-data" id="formularioRegistro">
                <nav>
                    <a href="{{ url('/') }}" id="inicioFormulario" class="apartado">Inicio</a>
                    <a href="{{ url('usuario/create') }}" id="registrarseFormulario" class="apartado">Registrarse</a> 
                </nav>
                @csrf
                <div id="agruparCamposRegistro">
                    @if(count($errors) > 0)
                        <div id="apartadoErrores">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="apartadoRegistroEdit" id="separadorInicio">
                        <div class="apartadoIcono">
                            <img class="imgInicio" src="{{ asset('photos/pc/ICONO-NOMBRE.png') }}">
                        </div>
                        <input type="text" class="apartadoEscribir" value="{{ isset($usuario->NombreUsuario) ? $usuario->NombreUsuario : old('NombreUsuario') }}" placeholder="Nombre" name="NombreUsuario" id="NombreUsuario">
                    </div>

                    <div class="apartadoRegistroEdit">
                        <div class="apartadoIcono">
                            <img class="imgInicio" src="{{ asset('photos/pc/ICONO-EMAIL.png') }}">
                        </div>    
                        <input type="email" class="apartadoEscribir" value="{{ isset($usuario->email) ? $usuario->email : old('email') }}" placeholder="Correo" name="email" id="email">
                    </div>

                    <div class="apartadoRegistroEdit">
                        <div class="apartadoIcono">
                            <img class="imgInicio" src="{{ asset('photos/pc/ICONO-CONTRASEÑA.png') }}">
                        </div>
                        <input type="password" class="apartadoEscribir" value="{{ isset($usuario->password) ? $usuario->password : old('password') }}" placeholder="Password" name="password" id="password">
                    </div>

                    <div class="apartadoRegistroEdit">
                        <div class="apartadoIcono">
                            <img class="imgInicio" src="{{ asset('photos/pc/ICONO-CURSO.png') }}">
                        </div>
                        <input class="apartadoEscribir" type="text" value="{{ isset($usuario->Curso) ? $usuario->Curso : old('Curso') }}" placeholder="Curso" name="Curso" id="Curso">
                    </div>

                    <div class="apartadoRegistroEdit">
                        <div class="apartadoIcono">
                            <img class="imgInicio" src="{{ asset('photos/pc/ICONO-FOTO.png') }}">
                        </div>
                        @if(isset($usuario->FotoUsuario))
                            <img src="{{ asset('storage') . '/' . $usuario->FotoUsuario }}" width="100" alt="FotoUsuario">
                        @endif
                        <input  class="apartadoEscribir" type="file" value="" placeholder="Fotografía" name="FotoUsuario" id="FotoUsuario">
                    </div>

                    <button type="submit" id="botonInicio">
                        Registrarse
                    </button>
                </div>
            </form>
        </div>
    </section>
    @extends('parts.footer')
</body>
</html>