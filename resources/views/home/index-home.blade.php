<link rel="stylesheet" type="text/css" href="{{ asset('css/home/home-user-pc.css') }}"/>
<body>
    @extends('parts.header')
    <div id="agruparCompleto">   
        @extends('parts.aside')
        <section>
            <ul>
                <li><img src="{{ asset('photos/pc/HOME-1.jpg') }}"></li>
                <li><img class="ajusteImagen" src="{{ asset('photos/pc/HOME-4.jpg') }}"></li>
                <li><img src="{{ asset('photos/pc/HOME-2.jpg') }}"></li>
                <li><img src="{{ asset('photos/pc/HOME-3.jpg') }}"></li>
                <li><img src="{{ asset('photos/pc/HOME-1.jpg') }}"></li>
            </ul>
            <div id="apartadoBienvenida">
                <h1 id="tituloPrinci">Bienvenid@: </h1>
                <?php
                    $nombre = $_SESSION['usuario_conectado']->NombreUsuario;          
                ?>
                <h1 id="nombreUsuario">{{$nombre}}</h1>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>
