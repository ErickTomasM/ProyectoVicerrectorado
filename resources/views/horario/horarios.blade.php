@extends('adminlte::page')
@section('template_title')
Horarios
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/prueba.css') }}">
@endsection
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{$docente->nombres}} {{$docente->paterno}} {{$docente->materno}}</h3>
        <div class="card-tools">
            <button id="toggle-table" class="btn btn-primary"><i class="fas fa-plus-circle"></i> </button>
            
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Grupo</th>
                        <th>Hrs. Totales</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materias as $materia)
                    @foreach($materia->asignaciones as $asignacion)
                    <tr>
                        <td>
                            {{ $materia->sigla }} - {{ $materia->materia }}
                            <br>
                            <small class="text-muted">Hrs. Teóricas: {{ $materia->hrs_teoricas }} - Hrs. Prácticas: {{ $materia->hrs_practicas }}</small>
                        </td>
                        <td>{{ $asignacion->grupo }}</td>
                        <td>{{ $materia->hrs_teoricas + $materia->hrs_practicas}}</td> 
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DESDE AQUI HORARIOS-->
<div class="row">
    <div class="col-md-6">
        <select name="ambiente" class="form-control">
            @foreach($ambiente_carrera as $ambiente)
            <option value="{{$ambiente->id_ambiente}}">{{$ambiente->ambiente->nro_ambiente}}</option>
            @endforeach
        </select>
    </div>
</div>

<form action="{{ route('horarios.guardar', $docente->id_docente) }}" method="POST">
    @csrf

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hora</th>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miércoles</th>
                <th>Jueves</th>
                <th>Viernes</th>
                <th>Sábado</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i <= 26; $i++)
                @php
                    $horaInicio = 7 + floor($i / 2);
                    $horaFin = 7 + floor(($i + 1) / 2);
                    $minutosInicio = $i % 2 == 0 ? '00' : '45';
                    $minutosFin = ($i + 1) % 2 == 0 ? '00' : '45';
                @endphp
                @if($horaFin <= 20 || ($horaFin == 21 && $minutosFin == '00'))
                    @if(!($horaFin == 12 && $minutosFin == '45') && !($horaFin == 14 && $minutosInicio == '00'))
                        <tr>
                            <td>{{ $horaInicio }}:{{ $minutosInicio }} - {{ $horaFin }}:{{ $minutosFin }}</td>
                            @for($j = 1; $j <= 6; $j++)
                                <td>
                                    <select name="materias[{{ $i }}][{{ $j }}]" class="form-control">
                                        <option value="">Seleccionar materia</option>
                                        @foreach($materias as $materia)
                                            <option value="{{ $materia->id_materia }}">{{ $materia->sigla }}</option>
                                        @endforeach
                                    </select>
                                    <select name="ambiente_carrera[{{ $i }}][{{ $j }}]" class="form-control">
                                        <option value="">Seleccionar ambiente</option>
                                        @foreach($ambiente_carrera as $ambiente)
                                            <option value="{{ $ambiente->id_ambiente }}">{{ $ambiente->ambiente->nro_ambiente }}</option>
                                        @endforeach
                                       
                                    </select>
                                </td>
                            @endfor
                        </tr>
                    @endif
                @endif
            @endfor
        </tbody>
    </table>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>



<!-- AQUI TERMINAN LOS HORARIOS -->
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $("#toggle-table").click(function(){
        $(".card-body table").toggle();
        var icon = $("#toggle-table i");
        if (icon.hasClass("fa-minus")) {
            icon.removeClass("fa-minus").addClass("fa-plus-circle");
        } else {
            icon.removeClass("fa-plus-circle").addClass("fa-minus");
        }
    });
});
</script>
@endsection

@endsection
