<link rel="stylesheet" type="text/css" href="{{ asset('css/visualizacion/mis-equipos-pc.css') }}"/>
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
                        <a href="#" class="enlaceMiga">Mis equipos</a>
                    </div>
                </nav>
                <h1 id="tituloPrincipal">Mis equipos</h1>
                <div id="seccionEquipos">
                    @foreach($equipos as $equipo)
                        <div id="apartadoEquipo">
                            <div id="imagenDelEquipo">
                                <img src="{{ asset('storage') . '/' . $equipo->FotoEquipo }}" id="imagenEquipo" alt="FotoEquipo" >
                            </div>
                            <div id="nombreDelEquipo">
                                {{ $equipo->NombreEquipo }}
                            </div>
                            <?php  
                                $nombre = DB::table('deportes')
                                    ->select('Nombre')
                                    ->where('id', '=',$equipo->DeporteId)->get();
                                $resultados_decodificados = json_decode($nombre);
                            ?>
                            <div id="deporteDelEquipo">{{$resultados_decodificados[0]->Nombre}}</div>
                            <form action="{{ route('mis.equipos.eliminate', ['id' => $equipo->id]) }}" method="post" id="formularioSalir">
                                @csrf
                                <input type="submit" onclick="return confirm('¿Quiere salir de este equipo?')" id="eliminarUsuarioEquipo" value="Salir del equipo">
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>