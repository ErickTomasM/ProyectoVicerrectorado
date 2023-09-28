@extends('adminlte::page')

@section('template_title')
Designación
@endsection

@section('content')

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Agregar Designación
        </button>
    </div>
    <!-- MODAL CREAR DESIGNACION -->
    <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Designación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'designaciones.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'modalForm']) !!}
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
                            {{ Form::label('fecha_desig', 'A partir de: ') }}
                            {{ Form::date('fecha_desig', null, ['class' => 'form-control']) }}
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('documento', 'Documento PDF') !!}
                            {!! Form::file('documento', ['class' => 'form-control-file', 'accept' => 'application/pdf']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tipo', 'Tipo de docente') !!}
                            {!! Form::select('tipo', ['Titulares' => 'Docentes titulares', 'Extraordinarios' => 'Docente por Convocatoria', 'Consultores' => 'Consultores'], null, ['class' => 'form-control', 'id' => 'tipo_docente']) !!}
                        </div>
                        <div class="form-group" id="convocatoria" style="display:none;">
                            {!! Form::label('convocatoria', 'Convocatoria') !!}
                            {!! Form::select('convocatoria', ['' => 'Seleccione una convocatoria', 'Primera' => 'Primera Convocatoria', 'Segunda' => 'Segunda Convocatoria', 'Tercera' => 'Tercera Convocatoria'], null, ['class' => 'form-control']) !!}
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
    
    
    <div class="card-body">
        <div class="table-responsive">
           
                <table id="designaciones_table" class="table table-striped table-hover">
                    <thead  class="bg-primary text-white">
                        <tr>
                            <th>Nro</th>
                            <th>Documento</th>
                            <th>Generar PDF</th>
                            <th>Periodo</th>
                            <th>Año</th>
                            <th>programa</th>
                            
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($designaciones as $designacion)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-warning btn-pdf" href="{{ url('storage/designaciones/' . $designacion->documento) }}" target="_blank">
                                            <i class="far fa-file-pdf" style="color:red"></i> 
                                            <span class="d-none d-md-inline">resolucion: {{$designacion->resolucion }} | Dictamen: {{$designacion->dictamen}}</span>
                                        </a>
                                    </div>
                                </td>  
                                <td>
                                    <div class="btn-group">
                                        <span class="d-none d-md-inline">
                                            @if($designacion->tipo_docente == 'Extraordinarios')
                                                <a class="btn btn-sm btn-info btn-pdf" href="{{ route('designaciones.pdfExtr', $designacion->id_designacion) }}" target="_blank">
                                                    <i class="far fa-file-pdf" style="color:red"></i>
                                                    {{$designacion->tipo_docente}} | {{$designacion->convocatoria}} Convocatoria
                                                </a>
                                            @elseif($designacion->tipo_docente == 'Titulares')
                                                <a class="btn btn-sm btn-info btn-pdf" href="{{ route('designaciones.pdf', $designacion->id_designacion) }}" target="_blank">
                                                    <i class="far fa-file-pdf" style="color:red"></i> 
                                                    Docentes:{{$designacion->tipo_docente}}  {{$designacion->periodo}}
                                                </a>
                                            @elseif($designacion->tipo_docente == 'Consultores')
                                                <a class="btn btn-sm btn-info btn-pdf" href="{{ route('designaciones.consultor', $designacion->id_designacion) }}">
                                                    <i class="far fa-file-pdf" style="color:red"></i>
                                                    {{$designacion->tipo_docente}} 
                                                </a>
                                            @endif
                                        </span>
                                    </div>
                                    
                                </td>
                                 
                                <td>{{$designacion->periodo}}</td>
                               <td>{{$designacion->anio}}</td>
                                
                                <td>{{$designacion->carrera->programa}}</td>
 
                                <td>
                                    <div class="btn-group">
                                        <form action="{{ route('designaciones.destroy', $designacion->id_designacion) }}" method="POST" id="deleteForm{{$designacion->id_designacion}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn" data-id="{{ $designacion->id_designacion }}">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </form>
                                        <!-- 
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $designacion->id_designacion }}">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        -->
                                        <a href="{{ route('asignaciones.materias', $designacion->id_designacion) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-plus-circle"></i> Asignar
                                        </a>
                                    </div>

                                </td>
                                
                                
                                
                                
                                
                            </tr>
   
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
    <!-- MODAL EDITAR DESIGNACION --> 
    @foreach($designaciones as $designacion)
    <div class="modal fade show" id="editModal{{ $designacion->id_designacion }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Designación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model($designacion, ['route' => ['designaciones.update', $designacion->id_designacion], 'method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' => 'modalForm']) !!}
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

                    {!! Form::label('anio', 'Gestión') !!}
                    {!! Form::select('anio', array_combine($anio, $anio), $anioActual, ['class' => 'form-control']) !!}

                    <div class="form-group">
                        {!! Form::label('periodo', 'Periodo') !!}
                        {!! Form::select('periodo', ['Gestión Académica' => 'Gestión Académica', 'Semestre I' => 'Semestre I', 'Semestre II' => 'Semestre II'], null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('fecha_desig', 'A partir de: ') }}
                        {{ Form::date('fecha_desig', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        {!! Form::label('documento', 'Documento PDF') !!}
                        {!! Form::file('documento', ['class' => 'form-control-file', 'accept' => 'application/pdf']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('tipo', 'Tipo de docente') !!}
                        {!! Form::select('tipo', ['Titulares' => 'Docentes titulares', 'Extraordinarios' => 'Docente por Convocatoria', 'Consultores' => 'Consultores'], $designacion->tipo ?? null, ['class' => 'form-control', 'id' => 'tipo_docente']) !!}
                    </div>
                    
                    <div class="form-group" id="convocatoria" style="display:none;">
                        {!! Form::label('convocatoria', 'Convocatoria') !!}
                        {!! Form::select('convocatoria', ['' => 'Seleccione una convocatoria', 'Primera' => 'Primera Convocatoria', 'Segunda' => 'Segunda Convocatoria', 'Tercera' => 'Tercera Convocatoria','Invitados' => 'Docentes Invitados'], $designacion->convocatoria ?? null, ['class' => 'form-control']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('carrera', 'Carrera') !!}
                        {!! Form::select('carrera', $carreras, $designacion->carrera ?? null, ['class' => 'form-control']) !!}
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
    @endforeach
    <!-- VISTA INDEX DESIGNACION -->
    @endsection
    <!-- AJAX -->
    @section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <link href="{{ asset('css/prueba.css') }}" rel="stylesheet">

    @endsection
    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"> </script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"> </script>
        <!-- jQuery -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        
        <script>
           $(document).ready(function() {
        $('#designaciones_table').DataTable( {
            "language": {
                "lengthMenu": "Mostrar _MENU_ Registros por Página",
                "zeroRecords": "No se encontro ningun Registro ",
                "info": "Mostrando la Página _PAGE_ de _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(Se filtraron _MAX_ registros totales)",
                "search": "Buscar",
                "paginate":{
                    "next": "siguiente",
                    "previous": "anterior"
                }
            }
        } );
    } );
        </script>
       <script>
        var tipoDocente = document.getElementById('tipo_docente');
        tipoDocente.addEventListener('change', function() {
            var convocatoria = document.getElementById('convocatoria');
            if (tipoDocente.value === 'Extraordinarios') {
                convocatoria.style.display = 'block';
            } else {
                convocatoria.style.display = 'none';
            }
        });
    </script>
    <script>
   $('#exampleModal form').submit(function(event) {
    event.preventDefault();

    var form = $(this);
    var url = form.attr('action');
    var method = form.attr('method');
    var formData = new FormData(form[0]);
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.invalid-feedback').remove();

    $.ajax({
        url: url,
        method: method,
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-Requested-With': 'XMLHttpRequest' // Agrega este encabezado
        },
        success: function(data) {
            if (data.errors) {
                var errors = data.errors;
                $.each(errors, function(field, messages) {
                    var fieldElement = $('#' + field);
                    fieldElement.addClass('is-invalid');
                    fieldElement.closest('.form-group').append('<div class="invalid-feedback">' + messages[0] + '</div>');
                });
            } else if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.success,
                    didClose: function() {
                        location.reload(); // Actualizar la página
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar la designación',
                    didClose: function() {
                        location.reload(); // Actualizar la página
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    var fieldElement = $('#' + field);
                    fieldElement.addClass('is-invalid');
                    fieldElement.closest('.form-group').append('<div class="invalid-feedback">' + messages[0] + '</div>');
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al realizar la petición',
                    didClose: function() {
                        location.reload();
                    }
                });
            }
            console.error(error);
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


