@if(count($errors) > 0)
    <div id="mensajesError">
        <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif


<h1 id="tituloPrincipal">{{ $modo }} deporte</h1>

<div id="agruparFormulario">
    <div class="apartadoFormulario">
        <label class="labelFormulario" for="Nombre">Nombre:</label>
        <input class="escribirFormulario" type="text" value="{{ isset($deporte->Nombre) ? $deporte->Nombre : old('Nombre') }}" name="Nombre" id="Nombre">
    </div>
    <div class="apartadoFormulario">
        <label class="labelFormulario"  for="Foto">Foto:</label>
        <input class="escribirFormulario" type="file" value="" name="Foto" id="Foto">
        @if(isset($deporte->Foto))
            <img src="{{ asset('storage') . '/' . $deporte->Foto }}" id="imagenAnterior" alt="FotoDeporte">
        @endif
    </div>
    <div id="apartadoAcciones">
        <input type="submit" id="botonEnviarT" value="{{ $modo }}" id="Enviar">
        <a id="botonVolver" href="{{ url('deporte/') }}">Volver</a>
    </div>
</div>

<img id="imagenFormulario" src="{{ asset('photos/pc/C-E-DEPORTES.jpg') }}">