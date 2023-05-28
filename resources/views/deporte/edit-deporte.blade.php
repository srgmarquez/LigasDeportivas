<link rel="stylesheet" type="text/css" href="{{ asset('css/deporte/create-edit-deporte-pc.css') }}"/>
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
                        <a href="{{ url('/deporte') }}" class="enlaceMiga">Gestión deportes</a>
                    </div>
                    <p class="simboloMiga">></p>
                    <div class="apartadoMiga" id="especialMiga">
                        <a href="#" class="enlaceMiga">Edición deporte</a>
                    </div>
                </nav>
                <form action="{{ url('/deporte/' . $deporte->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    @include('deporte.form-deporte', ['modo' => 'Editar'])
                </form>
            </div>
        </section>
    </div>
    @extends('parts.footer')
</body>