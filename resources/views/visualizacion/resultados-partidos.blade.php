<link rel="stylesheet" type="text/css" href="{{ asset('css/visualizacion/resultado-partido-pc.css') }}"/>
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
                        <a href="#" class="enlaceMiga">Resultados partidos</a>
                    </div>
                </nav>
                <div id="cabeceraPartidos">
                    <h1 id="tituloPartido">Resultados de los partidos</h1>
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
                                        Pendiente por jugar: {{$partido->FechaPartido}}
                                    @else
                                        Partido finalizado: {{$partido->FechaPartido}}
                                    @endif
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