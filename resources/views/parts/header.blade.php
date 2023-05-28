<link rel="stylesheet" type="text/css" href="{{ asset('css/parts/header.css') }}"/>
<script>
    function mostrarDesplegable() {
        var desplegable = document.getElementById("desplegable");
        desplegable.classList.toggle("mostrar");
    }
</script>
<header>
    <div id="apartadoLogo">
        <img id="imgLogo" src="{{ asset('photos/pc/LIGAS-DEPORTIVAS.png') }}">
    </div>
    
    <div id="parteImagenUsuario">
        <?php
            $email = $_SESSION['usuario_conectado']->email;
            $foto = $_SESSION['usuario_conectado']->FotoUsuario;
            
        ?>
        <div id="parteImagen">
            @if($foto == null)
                <img class="imagenUsuario" src="{{ asset('photos/pc/USUARIO-SINFOTO.png') }}" onclick="mostrarDesplegable()">
            @else
                <img class="imagenUsuario" src="{{ asset('storage') . '/' . $foto }}" width="100" alt="FotoEquipo" onclick="mostrarDesplegable()">
            @endif
        </div>
       
    </div>
    <div class="desplegable" id="desplegable">
        <ul id="selector">
            <li id="tituloOpciones">Opciones</li>
            <?php $idUsuario = $_SESSION['usuario_conectado']->id; ?>
            <li class="hoverLi"><a href="{{ url('/usuario/' . $idUsuario . '/edit') }}">Edición perfil</a></li>
            <li class="hoverLi"><a href="{{ route('salir.aplicacion') }}">Cerrar sesión</a></li>
        </ul>
    </div>
</header>


