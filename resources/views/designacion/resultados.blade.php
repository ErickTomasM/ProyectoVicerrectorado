@extends('adminlte::page')
@section('template_title')
    Designar Docente
@endsection
@section('content')

@if(count($docentes) > 0)
    <div class="modal fade" id="modalDesignar" tabindex="-1" role="dialog" aria-labelledby="modalDesignarTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDesignarTitle">Designar Docente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>CI</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Programa</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($docentes as $docente)
                                <tr>
                                    <td>{{ $docente->ci }}</td>
                                    <td>{{ $docente->nombres }}</td>
                                    <td>{{ $docente->paterno }} {{ $docente->materno }}</td>
                                    <td>{{ $docente->carreras->programa}}</td>
                                    <td>
                                        <a href="{{ route('designaciones.asignar', $docente->id) }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDesignar">
        Designar Docente
    </button>
@else
    <p>No se encontraron resultados.</p>
@endif
@endsection
