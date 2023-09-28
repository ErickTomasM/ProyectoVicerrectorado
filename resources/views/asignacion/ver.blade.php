@extends('adminlte::page')
@section('template_title')
    Ver asignaciones
@endsection
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 align="center">  {{$carrera}} </h3>
                    <h4 align="center">{{$periodo}}/{{$gestion}}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Docente</th>
                                <th>Materia</th>
                                <th>Sigla</th>
                                <th>Grupo</th>
                                <th>Segun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asignaciones as $asignacion)
                                <tr>
                                    <td> {{++ $i}}</td>
                                    <td>{{ $asignacion->docente->nombres }} {{ $asignacion->docente->paterno }} {{ $asignacion->docente->materno }}</td>
                                    <td>{{ $asignacion->materia->materia }}</td>
                                    <td>{{ $asignacion->materia->sigla }}</td>
                                    <td>{{ $asignacion->grupo }}</td>
                                    <td>Dict:{{ $asignacion->designacion->dictamen}} | Resol:{{ $asignacion->designacion->resolucion}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
