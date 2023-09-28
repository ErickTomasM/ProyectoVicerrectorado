@extends('adminlte::page')

@section('title', 'Carreras')

@section('content_header')
    <h1>Carreras de {{ auth()->user()->facultad }}</h1>
@stop

@section('content')
    <div class="row">
        @foreach($carreras as $carrera)
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $carrera->nombre }}</h3>
                    </div>
                    <div class="box-body">
                        <p>{{ $carrera->descripcion }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
