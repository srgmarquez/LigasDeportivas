<link rel="stylesheet" type="text/css" href="{{ asset('css/partido/create-edit-partido-pc.css') }}"/>
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
                        <a href="{{ url('/partido') }}" class="enlaceMiga">Gestión partidos</a>
                    </div>
                    <p class="simboloMiga">></p>
                    <div class="apartadoMiga" id="especialMiga">
                        <a href="#" class="enlaceMiga">Crear partido</a>
                    </div>
                </nav>
                <form action="{{ url('/partido') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('partido.form-partido', ['modo' => 'Crear'])
                </form>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>