<link rel="stylesheet" type="text/css" href="{{ asset('css/solicitud/edit-solicitud-pc.css') }}"/>
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
                        <a href="{{ url('/solicitud') }}" class="enlaceMiga">Solicitud Equipos</a>
                    </div>
                    <p class="simboloMiga">></p>
                    <div class="apartadoMiga"  id="larguraMiga">
                        <a href="#" class="enlaceMiga" >Aceptar / Denegar Solicitud</a>
                    </div>
                </nav>
                <h1 id="tituloPrincipal">Aceptar / denegar solicitud</h1>
                <form action="{{ url('/equipo') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $solicitud->id }}" name="SolicitudId" readonly>
                    <div class="agruparSolicitante">
                        <h3 class="datosDelSolicitante">Datos del solicitante: </h3>
                        <div class="datosYFoto">
                            <div class="agruparDatosSolicitante">
                                <div class="apartadoFormulario">
                                    <label class="labelFormulario" for="NombreUsuario">Nombre:</label>
                                    <input class="escribirFormulario" type="text" value="{{ $usuario->NombreUsuario }}" name="NombreUsuario" id="NombreUsuario" readonly>
                                    <input type="hidden" value="{{ $usuario->id }}" name="Capitan" id="Capitan" readonly>
                                </div> 
                                <div class="apartadoFormulario">           
                                    <label class="labelFormulario" for="RolUsuario">Rol:</label>
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
                                    <input class="escribirFormulario" type="text" value="{{ $rol }}" name="RolUsuario" id="RolUsuario" readonly>
                                </div>
                                <div class="apartadoFormulario">
                                    <label class="labelFormulario" for="CursoUsuario">Curso:</label>
                                    <input class="escribirFormulario" type="text" value="{{ $usuario->Curso }}" name="Curso" id="Curso" readonly>
                                </div>
                                <div class="apartadoFormulario">
                                    <label class="labelFormulario" for="email">Email:</label>
                                    <input class="escribirFormulario" type="text" value="{{ $usuario->email}}" name="email" id="email" readonly>
                                </div>
                            </div>
                            <div class="parteImagenFormulario">
                                @if($usuario->FotoUsuario == null)
                                    <img class="imagenUsuarioFormulario" src="{{ asset('photos/pc/USUARIO-SINFOTO.png') }}" ">
                                @else
                                    <img class="imagenUsuarioFormulario" src="{{ asset('storage') . '/' . $usuario->FotoUsuario }}" width="100" alt="FotoUsuario" ">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="agruparEquipoSolicitado">
                        <h3 class="datosDelSolicitante">Datos del equipo solicitado: </h3>
                        <div class="datosYFoto">
                            <div class="agruparDatosSolicitante">
                                <div class="apartadoFormulario">
                                    <label class="labelFormulario" for="NombreEquipo">Equipo:</label>
                                    <input class="escribirFormulario" type="text" value="{{ $solicitud->NombreEquipo }}" name="NombreEquipo" id="NombreEquipo" readonly>
                                </div> 
                                <div class="apartadoFormulario">
                                    <label class="labelFormulario" for="Deporte">Deporte:</label>
                                    <input type="hidden" value="{{ $deporte->id }}" name="DeporteId" id="DeporteId" readonly>
                                    <input class="escribirFormulario" type="text" value="{{ $deporte->Nombre }}"  id="DeporteId" readonly>
                                </div> 
                            </div>
                            <div class="parteImagenFormulario">
                                <input type="hidden" value="{{ $solicitud->FotoEquipo }}" name="FotoEquipo">
                                <img class="imagenUsuarioFormulario" src="{{ asset('storage') . '/' . $solicitud->FotoEquipo }}"  width="100" alt="FotoEquipo">  
                            </div>
                        </div>
                    </div>
                    <div id="apartadoBotones">
                        @if($solicitud->EstadoSolicitud == 0)
                            <button class="botonFormulario" id="botonAceptar" type="submit" name="botonAceptar" value="aceptar">Aceptar</button>
                            <button class="botonFormulario" id="botonDenegar" type="submit" name="botonRechazar" value="rechazar">Rechazar</button>
                        @endif
                    </div>
                </form>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>