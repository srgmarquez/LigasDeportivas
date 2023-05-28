@if(count($errors) > 0)
    <div id="mensajesError">
        <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<h1 id="tituloPrincipal">{{ $modo }} partido</h1>


<div id="agruparFormulario">
    <div id="apartadoEscudosEquipos">
        @if(isset($partido->EquipoLocal))
            <?php  $resultado = DB::table('partidos')
                                ->join('equipos', 'partidos.EquipoLocal', '=', 'equipos.id')
                                ->select('equipos.FotoEquipo')
                                ->where('equipos.id','=',$partido->EquipoLocal)
                                ->first();
            $fotoEquipo = htmlspecialchars($resultado->FotoEquipo);?>
            <div class="floatLeft">
                <div class="ajustarFotos">
                    <img class="imagenDentro"  src="{{ asset('storage') . '/' . $fotoEquipo }}"  id="imagenDeporte" alt="FotoDeporte">  
                </div>
            </div>
        @else    
            <div class="floatLeft">
                <div class="ajustarFotos">
                    <img class="imagenDentro"  src="{{ asset('photos/pc/ESCUDO-FONDO.png') }}"  id="imagenDeporte" alt="FotoDeporte">
                </div> 
            </div>
        @endif
        
        @if(isset($partido->EquipoVisitante))
            <?php  $resultado = DB::table('partidos')
                                ->join('equipos', 'partidos.EquipoVisitante', '=', 'equipos.id')
                                ->select('equipos.FotoEquipo')
                                ->where('equipos.id','=',$partido->EquipoVisitante)
                                ->first();
            $fotoEquipo = htmlspecialchars($resultado->FotoEquipo);?>
            <div class="floatLeft">
                <div class="ajustarFotos">
                    <img class="imagenDentro" src="{{ asset('storage') . '/' . $fotoEquipo }}"  id="imagenDeporte" alt="FotoDeporte">  
                </div>
            </div>
        @else    
            <div class="floatLeft">
                <div class="ajustarFotos">
                    <img class="imagenDentro" src="{{ asset('photos/pc/ESCUDO-FONDO.png') }}"  id="imagenDeporte" alt="FotoDeporte">
                </div> 
            </div>
        @endif
       
    </div>
    <div id="agruparGoles">
        @if($modo == 'Crear')
            <div class="golesLocal" id="marginGolesLocal">
                <input class="apartadoGoles"  type="number" value="0"  name="GolesEquipoLocal" readonly>
            </div>
            <div class="golesVisitante">
                <input class="apartadoGoles" type="number"  value="0" name="GolesEquipoVisitante" readonly>
            </div>
        @elseif($modo ==  'Editar')
            <div class="golesLocal" id="marginGolesLocal">
                <input class="apartadoGoles" type="text" value="{{isset($partido->GolesEquipoLocal) ? $partido->GolesEquipoLocal : old('GolesEquipoLocal')}}" name="GolesEquipoLocal">
            </div>
            <div class="golesVisitante">
                <input class="apartadoGoles" type="text" value="{{isset($partido->GolesEquipoVisitante) ? $partido->GolesEquipoVisitante : old('GolesEquipoVisitante')}}" name="GolesEquipoVisitante">
            </div>
        @endif
    </div>
    <div id="agruparNombres">
        <div id="nombreLocal">
            <label for="equipoLocal">Local:</label>
            <select id="equipoLocal" name="equipoLocal">
                @if(isset($partido->FechaPartido))
                    <?php  $resultado = DB::table('partidos')
                                    ->join('equipos', 'partidos.EquipoLocal', '=', 'equipos.id')
                                    ->select('equipos.NombreEquipo')
                                    ->where('equipos.id','=',$partido->EquipoLocal)
                                    ->first(); 
                    $nombreEquipo = htmlspecialchars($resultado->NombreEquipo);?>
                    <option value="{{$partido->EquipoLocal}}">{{$nombreEquipo}}</option>
                @else
                    <option>Seleccionar un equipo</option>
                @endif
                @foreach($equipos as $equipo)
                    <option value="{{$equipo->id}}">{{$equipo->NombreEquipo}}</option>
                @endforeach
            </select>
        </div>
        <div id="nombreVisitante">
            <label for="equipoVisitante">Visitante:</label>
            <select id="equipoVisitante" name="equipoVisitante">
                @if(isset($partido->FechaPartido))
                    <?php  $resultado = DB::table('partidos')
                                    ->join('equipos', 'partidos.EquipoVisitante', '=', 'equipos.id')
                                    ->select('equipos.NombreEquipo')
                                    ->where('equipos.id','=',$partido->EquipoVisitante)
                                    ->first(); 
                    $nombreEquipo = htmlspecialchars($resultado->NombreEquipo);?>
                    <option value="{{$partido->EquipoVisitante}}">{{$nombreEquipo}}</option>
                @else
                    <option>Seleccionar un equipo</option>
                @endif
                @foreach($equipos as $equipo)
                    <option value="{{$equipo->id}}">{{$equipo->NombreEquipo}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="apartadoFecha">
        <label for="FechaPartida">Fecha:</label>
        <input class="fechaPar" type="date"  value="{{isset($partido->FechaPartido) ? $partido->FechaPartido : old('FechaPartido')}}" name="FechaPartido">
    </div>
    <div id="apartadoAcciones">
        @if($modo == 'Crear')
            <button id="botonEnviarD" type="submit">{{$modo}} partido</button>
        @elseif($modo == 'Editar' && $partido->Estado != 'Finalizado')
            <button id="botonEnviarD" type="submit">{{$modo}} partido</button>
        @endif
        <a id="botonVolver" href="{{ url('/partido')}}">Volver</a>
    </div>
</div>
<div id="imagenFormulario">
    <img id="imagenLateral" src="{{ asset('photos/pc/IMG-PARTIDOS.jpg') }}"  id="imagenDeporte" alt="FotoDeporte">
</div>

