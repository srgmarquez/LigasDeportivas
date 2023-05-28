

@if(count($errors) > 0)
    <div class="mensajeAviso" id="mensajeErrores">
        <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

@if(Session::has('mensaje'))
    <div class="mensajeAviso" id="mensajeValidacion">
        {{ Session::get('mensaje')}}
    </div>
@endif

<h1 id="tituloPrincipal">Solicitud equipo</h1>

<div id="agruparFormulario">
    <div class="apartadoFormulario">
        <label class="labelFormulario" for="NombreEquipo">Nombre:</label>
        <input class="escribirFormulario" type="text" value="{{ isset($equipo->NombreEquipo) ? $equipo->NombreEquipo : old('NombreEquipo') }}" name="NombreEquipo" id="NombreEquipo">
    </div>

    <div class="apartadoFormulario">
        <label class="labelFormulario" for="FotoEquipo">Escudo:</label>
        <input class="escribirFormulario" type="file" value="" name="FotoEquipo" id="FotoEquipo">
        @if(isset($equipo->FotoEquipo))
            <img src="{{ asset('storage') . '/' . $equipo->FotoEquipo }}" width="100" alt="FotoEquipo">
        @endif
    </div>

    <div class="apartadoFormulario">
        <label class="labelFormulario" for="DeporteId">Deporte:</label>
        <select class="escribirFormulario" name="DeporteId">
            @if(isset($equipo->DeporteId))
                @php
                    $nombre_deporte = DB::select('SELECT Nombre FROM deportes WHERE id = ?', [$equipo->DeporteId]);
                    foreach($nombre_deporte as $value) {
                        $array[] = $value->Nombre;
                    } 
                    $nombre_deporte = $array[0];
                @endphp   
                <option value="{{ $equipo->DeporteId }}">{{ $nombre_deporte }}</option>
            @endif
            @foreach($deportes as $deporte)
                <option value="{{ $deporte->id }}">{{ $deporte->Nombre }}</option>
            @endforeach
        </select>
    </div>
    <div id="apartadoAcciones">
        <input type="submit" id="botonEnviarT" value="{{ $modo }}" id="Enviar">
        <a id="botonVolver" href="{{ url('home') }}">Volver</a>
    </div>
</div>

<img id="imagenFormulario" src="{{ asset('photos/pc/SOLICITUD-EQUIPO.jpg') }}">
