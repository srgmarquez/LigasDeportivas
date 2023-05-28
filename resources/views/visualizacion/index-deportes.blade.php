<link rel="stylesheet" type="text/css" href="{{ asset('css/visualizacion/index-deportes-pc.css') }}"/>
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
                        <a href="#" class="enlaceMiga">Deportes</a>
                    </div>
                </nav>
                <h1 id="tituloPrincipal">Deportes</h1>
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
                                
                                <a href="{{ route('equipos.show', ['id' => $deporte->id]) }}" id="equiposPorDeporte">Equipos</a>
                            </div>
                        </div>
                       
                    @endforeach   
                </div>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>