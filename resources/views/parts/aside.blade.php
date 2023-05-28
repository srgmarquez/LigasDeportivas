<link rel="stylesheet" type="text/css" href="{{ asset('css/parts/aside.css') }}"/>
<aside>
    <div id="agruparAside">
        <?php $id = $_SESSION['usuario_conectado']->id;
        $resultado = DB::table('usuario_rol')->select('Estado')->where('role_id','=',1)->where('usuario_id','=',$id)->first();
        $estado = htmlspecialchars($resultado->Estado);?>
        @if($estado == 1)
            <div id="parteAdministrador">
                <h2>ADMINISTRADOR</h2>
                <div class="cajaEnlace" id="primerEnlace">
                    <a class="enlacesAside" href="{{ url('/role') }}"> Asignar roles</a>
                </div>
                <div class="cajaEnlace">
                    <a class="enlacesAside" href="{{ url('/deporte') }}"> Gestionar deportes</a>
                </div>
            </div>
        @endif
        <?php  $resultado = DB::table('usuario_rol')->select('Estado')->where('role_id','=',2)->where('usuario_id','=',$id)->first();
        $estado = htmlspecialchars($resultado->Estado);?>
        @if($estado == 1)
            <div id="parteProfesor">
                <h2>PROFESOR</h2>
                <div class="cajaEnlace" id="primerEnlace">
                    <a class="enlacesAside" id="enlaceEspecial" href="{{ url('solicitud') }}"> Solicitudes equipos</a>
                    <?php $cantidad = DB::table('solicituds') ->where('EstadoSolicitud', '=', 0)->count(); ?>
                    @if($cantidad > 0)
                        <p id="numeroPeticiones">{{$cantidad}}</p>
                    @endif
                </div>
                <div class="cajaEnlace">
                    <a class="enlacesAside" href="{{ url('/partido')}}"> Gestión partidos</a>
                </div>
            </div>
        @endif
        <?php  $resultado = DB::table('usuario_rol')->select('Estado')->where('role_id','=',3)->where('usuario_id','=',$id)->first();
        $estado = htmlspecialchars($resultado->Estado);?>
        @if($estado == 1)
            <div id="parteAlumno">
                <h2>ALUMNO</h2>
                <div class="cajaEnlace" id="primerEnlace">
                    <a class="enlacesAside" href="{{ url('solicitud/create') }}"> Formar un equipo</a>
                </div>
                <div class="cajaEnlace">
                    <a class="enlacesAside" href="{{ url('/visualizacion-deportes')}}"> Listado deportes / equipos</a>
                </div>
                <div class="cajaEnlace">
                    <?php $id = $_SESSION['usuario_conectado']->id;?>
                    <a class="enlacesAside" href="{{ route('mis.equipos.show', ['id' => $id]) }}"> Mis equipos</a>
                </div>
                <div class="cajaEnlace">
                    <a class="enlacesAside" href="{{ url('/visualizacion-partidos')}}"> Ver resultados partidos </a>
                </div>
            </div>
        @endif
    </div>
</aside>