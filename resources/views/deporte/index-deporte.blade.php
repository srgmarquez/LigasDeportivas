<link rel="stylesheet" type="text/css" href="{{ asset('css/deporte/index-deportes-pc.css') }}"/>
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
                        <a href="#" class="enlaceMiga">Gestionar deportes</a>
                    </div>
                </nav>
                 @if(Session::has('mensaje'))
                    <div id="mensajeAviso">
                        {{ Session::get('mensaje')}}
                    </div>
                @endif
                <div id="cabeceraDeportes">
                    <h1 id="tituloDeportes">Gestión de deportes</h1>
                    <a href="{{ url('deporte/create') }}" id="nuevoDeporte">Nuevo deporte</a>
                </div>
                <div id="seccionDeportes">
                    @foreach($deportes as $deporte)
                        <div id="apartadoDeporte">
                            <div id="imagenDelDeporte">
                                <img src="{{ asset('storage') . '/' . $deporte->Foto }}" id="imagenDeporte" alt="FotoDeporte">
                            </div>
                            <div id="nombreDelDeporte">
                                {{ $deporte->Nombre }}
                            </div>
                            <div id="apartadoAcciones">
                                <a href="{{ url('/deporte/' . $deporte->id . '/edit') }}" id="editarDeporte">Editar</a>
                                <form action="{{ url('/deporte/'. $deporte->id) }}" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <input type="submit" onclick="return confirm('¿Quiere borrar este deporte?')" id="eliminarDeporte" value="Borrar">
                                </form>
                            </div>
                        </div>
                       
                    @endforeach   
                </div>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>
