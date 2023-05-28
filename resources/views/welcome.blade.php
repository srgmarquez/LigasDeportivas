<!DOCTYPE html>
<html>
<head>
    <title>Home - Bienvenida</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home-pc.css') }}"/>
</head>
<body>
    <section>
       <ul>
            <li><img src="{{ asset('photos/pc/HOME-FUTBOL.jpg') }}"></li>
            <li><img src="{{ asset('photos/pc/HOME-BALONCESTO.jpg') }}"></li>
            <li><img src="{{ asset('photos/pc/HOME-TENIS.jpg') }}"></li>
            <li><img src="{{ asset('photos/pc/HOME-BADMINTON.jpg') }}"></li>
            <li><img src="{{ asset('photos/pc/HOME-FUTBOL.jpg') }}"></li>
        </ul>
        <div id="agruparPortada">
            <header> LIGAS DEPORTIVAS DE RECREO </header>
            <h3>INSTITUTO PABLO SERRANO</h3>


             <!-- Formulario inicio -->
            <form action="{{ route('comprobarContraseña') }}" id="formularioLogin">
                <nav>
                    <a href="#" id="inicioFormulario" class="apartado">Inicio</a>
                    <a href="{{ url('usuario/create') }}" id="registrarseFormulario" class="apartado">Registrarse</a> 
                </nav>
                @csrf

                <div id="agruparEmailPass">
                    <div clas="apartadoInicio">
                        @if(Session::has('mensaje'))
                            <p id="alerta">{{ Session::get('mensaje')}}</p>
                        @endif
                    </div>
                    <div class="apartadoInicio" id="separadorInicio">
                        <div class="apartadoIcono">
                            <img class="imgInicio" src="{{ asset('photos/pc/ICONO-EMAIL.png') }}">
                        </div>
                        <input class="apartadoEscribir" id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Correo" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <!--@error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror-->
                    </div>

                    <div class="apartadoInicio">
                        <div class="apartadoIcono">
                            <img class="imgInicio" src="{{ asset('photos/pc/ICONO-CONTRASEÑA.png') }}">
                        </div>
                        <input class="apartadoEscribir" id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" name="password" required autocomplete="current-password">
                        <!--@error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror-->
                    </div>

                    <button type="submit" id="botonInicio">
                        Acceder
                    </button>
                </div>
            </form>
        </div>
    </section>
    @extends('parts.footer')
</body>
</html>
