<link rel="stylesheet" type="text/css" href="{{ asset('css/rol/index-rol-pc.css') }}"/>
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
                    <div class="apartadoMiga">
                        <a href="#"  class="enlaceMiga">Asignar roles</a>
                    </div>
                </nav>
                <h1 id="tituloPrincipal">Asignación de roles a usuarios</h1>
                <table>
                    <tr>
                        <th>Nombre Usuario</th>
                        <th>Email</th>
                        <th>Tipo de Rol</th>
                        <th>Activar / Desactivar Rol</th>
                    </tr>
                    @foreach($usuarios as $usuario)
                        @foreach($usuario->roles as $role)
                            <tr>
                                <td>{{$usuario->NombreUsuario}}</td>
                                <td>{{$usuario->email}}</td>
                                <td>{{$role->NombreRol}}</td>  
                                <?php $estado = $role->pivot->Estado; ?>        
                                <td id="botonesRoles">
                                    <form action="{{ url('/role/'. $role->id) }}" method="post" id="formularioRoles">
                                        @csrf
                                        {{ method_field('PATCH') }}
                                        <input type="hidden" name="usuario_id" value="{{$usuario->id}}">
                                        <input type="hidden" name="role_id" value="{{$role->id}}">
                                        <input type="hidden" name="estado" value="{{$estado}}">
                                        @if ($estado == 1)
                                            <input type="submit" class="botonRol" id="desactivar" value="Desactivar">
                                        @endif
                                        @if ($estado == 0)
                                            <input type="submit" class="botonRol"  id="activar" value="Activar">
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @endforeach        
                    @endforeach
                </table>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>