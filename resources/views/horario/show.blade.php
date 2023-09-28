@extends('adminlte::page')
@section('template_title')
Horarios
@endsection
@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header text-center">
                <h2 class="mb-0">{{$carrera}}</h2>
                <h3 class="mb-0">{{$periodo}}/{{$gestion}}</h3>
            </div>            
            <div class="card-body p-0">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Docentes</th>
                            <th>Asignar Horarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($docentes as $id_docente => $nombre)
                        <tr>
                            <td>{{ $nombre }}</td>
                            <td><a href="{{ route('horarios.show', $id_docente)}}" class="add-horario"><i class="fas fa-plus-circle add-icon"></i></a></td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<style>
    .table {
        margin: 0 auto;
        width: 60%;
        font-size: 16px;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle !important;
    }

    .add-horario {
        font-size: 40px;
        color: green;
        text-decoration: none;
    }

    .add-icon {
    font-size: 30px;
    margin-right: 5px;
}

</style>
@endsection
@section('js')
@endsection
