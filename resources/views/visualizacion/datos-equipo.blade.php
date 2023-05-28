<link rel="stylesheet" type="text/css" href="{{ asset('css/visualizacion/datos-equipo-pc.css') }}"/>
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
                        <a href="{{ route('equipos.show', ['id' => $equipo->DeporteId]) }}"  class="enlaceMiga">Equipos por deporte</a>
                    </div>
                    <p class="simboloMiga">></p>
                    <div class="apartadoMiga" id="apartadoEspecial">
                        <a href="#"  class="enlaceMiga">Detalle equipo</a>
                    </div>
                </nav>
                <h1 id="tituloPrincipal">Equipo: <?php echo $equipo->NombreEquipo ?></h1>
                <div id="apartadoInformacionGeneral">
                    <div id="apartadoDatos">
                        <?php $deporte= DB::table('deportes')->select('Nombre')->where('id', '=', $equipo->DeporteId)->first();?>
                        <div id="primeraParte">
                            <p>Equipo al que pertenece: </p>
                            <p>Partidos jugados:</p>
                            <p>Partidos ganados: </p>
                            <p>Partidos perdidos: </p>
                            <p>Partidos empatados: </p>
                            <p>Puntos totales:</p>
                        </div>
                        <div id="segundaParte">
                            <p><?php echo $deporte->Nombre ?> </p>
                            <p><?php echo $equipo->PartidosJugados?></p>
                            <p id="colorVerde"><?php echo $equipo->PartidosGanados?></p>
                            <p id="colorRojo"><?php echo $equipo->PartidosPerdidos?></p>
                            <p id="colorMorado"><?php echo $equipo->PartidosEmpatados?></p>
                            <p><?php echo $equipo->PuntosTotales?></p>
                        </div>
                    </div>
                    <div id="apartadoEscudo">
                        <img id="imagenUsuario" src="{{ asset('storage') . '/' . $equipo->FotoEquipo }}" width="100" alt="FotoEquipo"">
                    </div>
                </div>
                <div id="apartadoFormacionEquipo">
                    <h3 class="tituloEquipo">Alumnos que forman el equipo</h3>
                    <table>
                        <tr>
                            <th>Foto</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Equipación</th>
                        </tr>
                        <?php $contador = 0; 
                        foreach($usuarios as $usuario) { ?>
                            <tr>
                                <td id="apartadoImagen">
                                    <img  id="imagenUsuarioEquipo" src="{{ asset('storage') . '/' . $usuario->FotoUsuario }}" width="100px" alt="FotoEquipo">
                                </td>
                                <td><?php echo $usuario->email?></td>
                                <?php 
                                    $rol = "ALUMNO";
                                    $valorEstado = DB::table('usuario_rol')->select('Estado')->where('role_id', '=', 1)->where('usuario_id', '=', $usuario->id)->get();
                                    $resultados_decodificados = json_decode($valorEstado);
                                    if($valorEstado[0]->Estado == 1){
                                        $rol = "ADMINISTRADOR";
                                    } else {
                                        $valorEstado = DB::table('usuario_rol')->select('Estado')->where('role_id', '=', 2)->where('usuario_id', '=', $usuario->id)->get();
                                        $resultados_decodificados = json_decode($valorEstado);
                                        if($valorEstado[0]->Estado == 1){
                                            $rol = "PROFESOR";
                                        }
                                    }    
                                ?>
                                <td><?php echo $rol ?></td>
                                <?php if($contador <= 0) { ?>
                                    <td>Capitán</td>
                                    <?php $contador++;
                               } else { ?>
                                    <td>Jugador</td>
                                <?php } ?>  
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>