<link rel="stylesheet" type="text/css" href="{{ asset('css/visualizacion/index-equipos-pc.css') }}"/>
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
                        <a href="{{ url('/visualizacion-deportes')}}" class="enlaceMiga">Deportes</a>
                    </div>
                    <p class="simboloMiga">></p>
                    <div class="apartadoMiga" id="apartadoEspecial">
                        <a href="#"  class="enlaceMiga">Equipos por deporte</a>
                    </div>
                </nav>
                <?php if($mensaje != "") { ?>
                    <div id="mensajeAviso">
                        <?php echo $mensaje ?>
                    </div>
                <?php } ?>
                <h1 id="tituloPrincipal">Equipos del deporte: {{$deporte->Nombre}}</h1>
                <div id="seccionEquipos">
                    <?php $contador = 1; ?>
                    @foreach($equipos as $equipo)
                        <?php $cantidad = 0; ?>
                        @if($contador == 1)
                            <div id="apartadoEquipoPrimero" class="compartirEquipo">
                        @elseif($contador == 2)
                            <div id="apartadoEquipoSegundo" class="compartirEquipo">
                        @elseif($contador == 3)
                            <div id="apartadoEquipoTercero" class="compartirEquipo">
                        @else
                            <div id="apartadoEquipo" class="compartirEquipo">
                        @endif
                            <div class="apartadoFloat">
                                <div id="apartadoPosicion">
                                    {{$contador}}º
                                </div>
                            </div>
                            <div class="apartadoFloat">
                                <div id="imagenDelEquipo">
                                    <img src="{{ asset('storage') . '/' . $equipo->FotoEquipo }}" id="imagenEquipo" alt="FotoEquipo">
                                </div>
                            </div>
                            <div id="nombreDelEquipo">
                                {{ $equipo->NombreEquipo }}
                            </div>
                            <div id="apartadoAcciones">
                                <a href="{{ route('datos.equipo.show', ['id' => $equipo->id]) }}" class="apartadoBoton" id="masInfo">+ INFO</a>
                                <?php 
                                    $id = $_SESSION['usuario_conectado']->id; 
                                    $cantidad = DB::table('usuario_equipo') ->where('equipo_id', '=', $equipo->id)->where('usuario_id', '=', $id)->count(); 
                                if ($cantidad >= 1){ ?>
                                    <a href="#" class="apartadoBoton" id="yaEquipo">Ya en el equipo</a>
                                <?php } else { ?>
                                    <a href="{{ route('equipos.unirse', ['id' => $equipo->id]) }}" class="apartadoBoton" id="solicitud">Solicitar unirse</a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php $contador++; ?>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>
