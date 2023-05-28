<link rel="stylesheet" type="text/css" href="{{ asset('css/solicitud/index-solicitud-pc.css') }}"/>
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
                        <a href="#" class="enlaceMiga">Solicitud Equipos</a>
                    </div>
                </nav>
                <h1 id="tituloPrincipal">Listado solicitudes</h1>
                <table>
                    <tr>
                        <th>Usuario que envia la solicitud</th>
                        <th>Rol</th>
                        <th>Resolución de la solicitud</th>
                        <th>+ INFO de la solicitud</th>
                    </tr>
                    @foreach($solicitudes as $solicitud)
                        <tr>
                            <?php 
                                $nombreUsuario = DB::table('usuarios')->select('NombreUsuario')->where('id', '=', $solicitud->UsuarioId)->get();
                                $resultados_decodificados = json_decode($nombreUsuario);
                            ?>
                            <td>{{$resultados_decodificados[0]->NombreUsuario}}</td>
                            <?php 
                                $rol = "ALUMNO";
                                $valorEstado = DB::table('usuario_rol')->select('Estado')->where('role_id', '=', 1)->where('usuario_id', '=', $solicitud->UsuarioId)->get();
                                $resultados_decodificados = json_decode($valorEstado);
                                if($valorEstado[0]->Estado == 1){
                                    $rol = "ADMINISTRADOR";
                                } else {
                                    $valorEstado = DB::table('usuario_rol')->select('Estado')->where('role_id', '=', 2)->where('usuario_id', '=', $solicitud->UsuarioId)->get();
                                    $resultados_decodificados = json_decode($valorEstado);
                                    if($valorEstado[0]->Estado == 1){
                                        $rol = "PROFESOR";
                                    }
                                }    
                            ?>
                            <td>{{$rol}}</td>
                            @if($solicitud->ResolucionSolicitud == "Pendiente")
                                <td id="pendiente">{{$solicitud->ResolucionSolicitud}}</td>
                            @endif
                            @if($solicitud->ResolucionSolicitud == "Aprobada")
                                <td id="aprobada">{{$solicitud->ResolucionSolicitud}}</td>
                            @endif
                            @if($solicitud->ResolucionSolicitud == "Denegada")
                                <td id="denegada">{{$solicitud->ResolucionSolicitud}}</td>
                            @endif
                            <td>
                                <a href="{{ url('/solicitud/' . $solicitud->id . '/edit') }}" id="enlaceSolicitud">Ver</a>
                                
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>