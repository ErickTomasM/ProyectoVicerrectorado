@extends('adminlte::page')
@section('title', 'Designación')
@section('content_header')
    <div class="card-header text-center">
        <h3>{{ $reasignacion->carrera->programa }}</h3>
        <h3>{{ $reasignacion->periodo }}/{{ $reasignacion->anio }}</h3>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/prueba.css') }}">
    <style>
        .center {
            text-align: left;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @foreach ($docentes as $docente)
                <div class="row">
                    <div class="col-md-8 center">
                        <h5>
                            <span class="toggle-content toggle-link"><i class="fas fa-plus-circle"></i></span>
                            {{ $docente->nombres }} {{ $docente->paterno }} {{ $docente->materno }}
                        </h5>
                    </div>
                    <div class="col-md-4">
                        <p class="docente-link">
                            <a href="{{ route('reasignaciones.materias', ['id_reasignacion' => $reasignacion->id_reasignacion, 'id_docente' => $docente->id_docente]) }}" class="btn btn-success">Reasignar</a>
                        </p>
                        
                    </div>
                </div>
                <ul class="docente-materias" style="display: none;">
                    @foreach ($docente->asignaciones as $asignacion)
                        <li>{{ $asignacion->materia->sigla }} {{ $asignacion->materia->materia }} (Grupo: {{ $asignacion->grupo }})</li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".toggle-content").click(function(){
                var ul = $(this).closest('.row').next(".docente-materias");
                ul.slideToggle();
                var icon = $(this).find("i");
                icon.toggleClass("fa-minus fa-plus-circle");
            });
        });
    </script>
@endsection
