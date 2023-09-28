<!-- resources/views/reasignaciones/index.blade.php -->

@extends('adminlte::page')

@section('template_title')
Designación
@endsection

@section('content')

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearReasignacionModal">
    Crear Reasignación
</button>

<!-- Ventana modal para crear una reasignación -->
<div class="modal fade" id="crearReasignacionModal" tabindex="-1" role="dialog" aria-labelledby="crearReasignacionModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearReasignacionModalLabel">Crear Reasignación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'reasignaciones.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                        {!! Form::label('resolucion', 'Resolución') !!}
                        {!! Form::number('resolucion', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('gestion', 'Fecha Resolución') !!}
                        {!! Form::date('gestion', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('dictamen', 'Dictamen') !!}
                        {!! Form::number('dictamen', null, ['class' => 'form-control']) !!}
                        @error('dictamen')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {!! Form::label('anio', 'Gestion') !!}
                    {!! Form::select('anio', array_combine($anio, $anio), $anioActual, ['class' => 'form-control']) !!}

                    <div class="form-group">
                        {!! Form::label('periodo', 'Periodo') !!}
                        {!! Form::select('periodo', ['Gestión Académica' => 'Gestión Académica', 'Semestre I' => 'Semestre I', 'Semestre II' => 'Semestre II'], null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('fecha_reasig', 'A partir de: ') }}
                        {{ Form::date('fecha_reasig', null, ['class' => 'form-control']) }}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('documento', 'Documento PDF') !!}
                        {!! Form::file('documento', ['class' => 'form-control-file', 'accept' => 'application/pdf']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('carrera', 'Carrera') !!}
                        {!! Form::select('carrera', $carreras ,null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group text-left">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- Vista Reasignacion -->
<!-- modal edit -->

<!-- Vista -->

<div class="card-body">
    <div class="table-responsive">
        <table id="designaciones_table" class="table table-striped table-hover">
            <thead  class="bg-primary text-white">
                <tr>
                    <th>N°</th>
                    <th>Documento</th>
                    <th>Generar PDF</th>
                    <th>Año</th>
                    <th>Periodo</th>

                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reasignaciones as $reasignacion)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a class="btn btn-sm btn-warning btn-pdf" href="{{ asset('storage/reasignaciones/' . $reasignacion->documento) }}">
                                <i class="far fa-file-pdf" style="color:red"></i> 
                                <span class="d-none d-md-inline">Resolución: {{$reasignacion->resolucion}} | Dictamen: {{$reasignacion->dictamen}}</span>
                            </a>
                        </td>
                        <td> 
                            <a class="btn btn-sm btn-info btn-pdf" href="{{ route('reasignaciones.pdf', $reasignacion->id_reasignacion) }}" target="_blank">
                                <i class="far fa-file-pdf" style="color:red"></i> 
                                Generar Reasignación
                            </a>
                        </td>
                        <td>{{$reasignacion->anio}}</td>
                        <td>{{ $reasignacion->periodo }}</td>
                    
                        <td>{{ $reasignacion->carrera->programa }}</td>
                        <td>
                            <div class="btn-group">
                                <form action="{{ route('reasignaciones.destroy', $reasignacion->id_reasignacion) }}" method="POST" id="deleteForm{{ $reasignacion->id_reasignacion }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-btn" data-id="{{ $reasignacion->id_reasignacion }}">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                                <a href="{{ route('reasignaciones.reasig', $reasignacion->id_reasignacion) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus-circle"></i> Reasignar
                                </a>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <link href="{{ asset('css/prueba.css') }}" rel="stylesheet">
    
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#designaciones_table').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ Registros por Página",
                    "zeroRecords": "No se encontró ningún Registro",
                    "info": "Mostrando la Página _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(Se filtraron _MAX_ registros totales)",
                    "search": "Buscar",
                    "paginate": {
                        "next": "siguiente",
                        "previous": "anterior"
                    }
                }
            });
        });
    </script>
   <script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            var designacionId = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro de que deseas eliminar esta designación?',
        
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '',
                cancelButtonColor: '',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm' + designacionId).submit();
                }
            });
        });
    });
</script>


@endsection

@endsection
