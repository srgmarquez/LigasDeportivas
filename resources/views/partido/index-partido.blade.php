<link rel="stylesheet" type="text/css" href="{{ asset('css/partido/index-partido-pc.css') }}"/>
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
                        <a href="#" class="enlaceMiga">Gestión partidos</a>
                    </div>
                </nav>
                @if(Session::has('mensaje'))
                    <div id="mensajeAviso">
                        {{ Session::get('mensaje')}}
                    </div>
                @endif
                <div id="cabeceraPartidos">
                    <h1 id="tituloPartido">Gestión de partidos</h1>
                    <a href="{{ url('partido/create') }}" id="nuevoPartido">Nuevo partido</a>
                </div>
                <div id="seccionPartidos">
                    @foreach($partidos as $partido)
                        <div id="apartadoPartido">
                            <?php $resultado = DB::table('partidos')
                                            ->join('equipos', 'partidos.EquipoLocal', '=', 'equipos.id')
                                            ->join('deportes', 'equipos.DeporteId', '=', 'deportes.id')
                                            ->select('deportes.Nombre')
                                            ->first(); 
                                $nombreDeporte = htmlspecialchars($resultado->Nombre);
                            ?>
                            <div id="nombreDeporte">
                                <div class="posicionarTexto">{{$nombreDeporte}}</div>
                            </div>
                            <?php $resultado = DB::table('partidos')
                                            ->join('equipos', 'partidos.EquipoLocal', '=', 'equipos.id')
                                            ->select('equipos.FotoEquipo')
                                            ->where('equipos.id',"=",$partido->EquipoLocal)
                                            ->first(); 
                                $imagenLocal = htmlspecialchars($resultado->FotoEquipo);
                            ?>
                            <div class="imagenEscudo" id="primerEscudo">
                                <div class="paraPosicion">
                                    <img class="imagenDentro" src="{{ asset('storage') . '/' . $imagenLocal }}"  id="imagenDeporte" alt="FotoDeporte">
                                </div>
                            </div>
                            <div id="resultadoPartido">
                                <div class="posicionarTexto">{{$partido->GolesEquipoLocal}} - {{$partido->GolesEquipoVisitante}}</div>
                            </div>
                            <?php $resultado = DB::table('partidos')
                                            ->join('equipos', 'partidos.EquipoVisitante', '=', 'equipos.id')
                                            ->select('equipos.FotoEquipo')
                                            ->where('equipos.id',"=",$partido->EquipoVisitante)
                                            ->first(); 
                                $imagenVisitante = htmlspecialchars($resultado->FotoEquipo);
                            ?>
                            <div class="imagenEscudo">
                                <div class="paraPosicion">
                                    <img class="imagenDentro" src="{{ asset('storage') . '/' . $imagenVisitante }}"  id="imagenDeporte" alt="FotoDeporte">
                                </div>
                            </div>
                            <div id="apartadoEstado">
                                <div class="posicionarTexto">
                                    @if($partido->Estado == "Pendiente")
                                        Pendiente por jugar {{$partido->FechaPartido}}
                                    @else
                                        Partido finalizado {{$partido->FechaPartido}}
                                    @endif
                                </div>
                            </div>
                            <div id="apartadoAcciones">
                                <div class="posicionarTexto">
                                    @if($partido->Estado == "Pendiente")
                                        <a class="botonEditar" href="{{ url('/partido/' . $partido->id . '/edit') }}">Colocar resultado</a>
                                    @else
                                        <a class="botonEditar" href="{{ url('/partido/' . $partido->id . '/edit') }}">Consultar datos partido</a>
                                    @endif
                                    <form action="{{ url('/partido/'. $partido->id) }}" method="post">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <input type="submit" onclick="return confirm('¿Quiere borrar este partido?')" id="botonEliminar" value="Eliminar">
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>