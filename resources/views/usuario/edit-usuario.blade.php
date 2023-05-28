<link rel="stylesheet" type="text/css" href="{{ asset('css/usuarios/edit-user-pc.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('css/parts/miga.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('css/parts/estructura.css') }}"/>
<body>
    @extends('parts.header')
    <div id="agruparCompleto">
        @extends('parts.aside')
        <section>
            <div id="plantillaSection">
                <nav>
                    <div class="apartadoMiga">
                        <a href="{{ url('/home') }}"  class="enlaceMiga">Home</a>
                    </div>
                    <p class="simboloMiga">></p>
                    <div class="apartadoMiga" id="especialMiga">
                        <a href="#" class="enlaceMiga">Edición usuario</a>
                    </div>
                </nav>
                <form action="{{ url('/usuario/' . $usuario->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    @if(count($errors) > 0)
                        <div id="mensajesError">
                            <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('mensaje'))
                        <div id="mensajeAviso">
                            {{ Session::get('mensaje')}}
                        </div>
                    @endif
                    <h1 id="tituloPrincipal">Edición perfil</h1>
                    <div id="agruparFormularioTextos">
                        <div class="apartadoFormulario">
                            <label class="labelFormulario" for="Nombre">Nombre:</label>
                            <input class="escribirFormulario" type="text" value="{{ $usuario->NombreUsuario }}" name="NombreUsuario" id="NombreUsuario">
                        </div>
                        <div class="apartadoFormulario">
                            <label class="labelFormulario" for="email">Email:</label>
                            <input class="escribirFormulario" type="email" value="{{ isset($usuario->email) ? $usuario->email : old('email') }}" name="email" id="email">
                        </div>
                        <div class="apartadoFormulario">
                            <label class="labelFormulario" for="Curso">Curso:</label>
                            <input class="escribirFormulario" type="text" value="{{ isset($usuario->Curso) ? $usuario->Curso : old('Curso') }}" name="Curso" id="Curso">
                        </div>
                        <div class="apartadoFormulario">
                            <p class="textoInformativo" id="textoUno">Si desea cambiar su contraseña, escribala aquí: </p>
                            <p class="textoInformativo" id="textoDos">En caso de que este campo se encuentre vacio, permanecerá la contraseña actual </p>
                            <label class="labelFormulario" for="Contraseña">Contraseña:</label>
                            <input class="escribirFormulario" type="password"  name="password" id="password">
                        </div>
                        <div id="apartadoAcciones">
                            <input type="submit" id="botonEnviar" value="Cambiar" id="Cambiar">
                        </div>
                    </div>
                    <div id="agruparFormularioFoto">
                        <div class="apartadoFormulario">
                            <div id="recuadroImagen">
                                @if(isset($usuario->FotoUsuario))
                                    <img class="imagenUsuario" src="{{ asset('storage') . '/' . $usuario->FotoUsuario }}" id="imagenAnterior" alt="FotoDeporte">
                                @else
                                    <img class="imagenUsuario" src="{{ asset('photos/pc/USUARIO-SINFOTO.png') }}">
                                @endif
                            </div>
                            <label class="labelFormulario"  for="Foto">Foto:</label>
                            <input class="escribirFormulario" type="file" value="" name="FotoUsuario" id="FotoUsuario">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>