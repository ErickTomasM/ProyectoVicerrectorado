@extends('adminlte::page')
@section('template_title')
    Asignar materias
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<link href="{{ asset('css/grupos.css') }}" rel="stylesheet">


@endsection
@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


<div class="container text-center">
    <label class="h4 text-info">{{ $designacion->carrera->programa }} | Resolución: {{ $designacion->resolucion }} | Dictamen: {{ $designacion->dictamen }}</label>
</div>

<form method="POST" action="{{ route('asignaciones.store') }}">
    @csrf
    <div class="form-group">
        <label for="id_docente" class="h4 text-info">Seleccione el docente:</label>
        <select name="id_docente" id="id_docente" class="docentes form-control">
            <option value="">Seleccionar docente</option> <!-- Opción vacía sin etiqueta de visualización -->
            @foreach ($docentes as $docente)
                <option value="{{ $docente->id_docente }}">{{ $docente->nombres }} {{ $docente->paterno }} {{ $docente->materno }}</option>
            @endforeach
        </select>
    </div>
    

    <div class="d-flex justify-content-between">
        <a href="{{ route('designaciones.index') }}" class="btn btn-primary mt-3">Terminar asignación</a>
        <button type="submit" class="btn btn-success mt-3 mr-3">Asignar materias</button>
    </div> <br>
    <table class="table table-striped" id="asignaciones_table">
        <thead class="bg-primary text-white">
            <tr>
                <th>N°</th>
                <th>Materia</th>
                <th>Total Horas</th>
                <th>Grupo</th>
                <th>Asignado a</th>
                
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
         
            @foreach($materias as $materia)
                <tr>
                    <td>{{ ++$i}}</td>
                    <td>
                        {{ $materia->sigla }} - {{ $materia->materia }}
                        <br>
                        <small class="text-muted">Hrs. Teóricas: {{ $materia->hrs_teoricas }} - Hrs. Prácticas: {{ $materia->hrs_practicas }}</small>
                    </td>
                    <td>{{ $materia->hrs_teoricas + $materia->hrs_practicas }}</td>
                    <td id="grupo-td">
                        <select name="grupo_{{ $materia->id_materia }}[]" class="form-select form-select-lg mb-3 docentes select2-group" id="grupo_{{ $materia->id_materia }}" multiple>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo }}">G{{ $grupo }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <div class="asignaciones-container">
                            @foreach($materia->asignaciones as $asignacion)
                                <div class="asignacion-item">
                                    <div class="asignacion-info">
                                        <span class="grupo">G{{$asignacion->grupo}}</span>
                                        <span class="nombre-docente">{{ $asignacion->docente->nombres }} {{ $asignacion->docente->paterno }} {{ $asignacion->docente->materno }}</span>
                                        <span class="grupo">{{$asignacion->periodo}}</span>
                                    </div>
                                    <button class="btn btn-outline-secondary btn-sm eliminar-asignacion-btn" data-asignacion-id="{{ $asignacion->id_asignacion }}">
                                        <i class="fas fa-times text-dark" style="cursor: pointer;"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </td>

                    
                    
                    <td>
                        <div class="form-check form-switch">
                            <input name="materias[]" value="{{ $materia->id_materia }}" type="checkbox" class="btn-check" id="id_materia_{{ $materia->id_materia }}" autocomplete="off">
                            <label class="btn btn-outline-success" for="id_materia_{{ $materia->id_materia }}">Asignar</label>
                        </div>
                    </td>
                </tr>
            @endforeach
        
        </tbody>
    </table>
    <input type="hidden" name="id_designacion" value="{{ $designacion->id_designacion }}">
    <input type="hidden" name="anio" value="{{ $designacion->anio }}">
    <input type="hidden" name="periodo" value="{{ $designacion->periodo }}">
</form>

@endsection

<!-- AJAX -->

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"> </script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"> </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <SCRipt>
        $(document).ready(function() {
    $('.docentes').select2({
        width: '50%',
    });
});
    </SCRipt>
    <script>
        $(document).ready(function() {
            $('.select2-group').select2({
                width: '100%',
                templateSelection: function(selected, container) {
                    $(container).css('background-color', 'white');
                    $(container).css('color', 'black');
                    return selected.text;
                }
            });
        });
    </script>

    <script>
$(document).ready(function() {
    $('#asignaciones_table').DataTable({
        "paging": false,
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
        },
        "orderCellsTop": true,
        "highlight": true
    });
});


    </script>
    <script>
        $(document).ready(function() {
            $('.eliminar-asignacion-btn').click(function(event) {
                event.preventDefault();
                var asignacionId = $(this).data('asignacion-id');
                eliminarAsignacion(asignacionId);
            });
        });
    
        function eliminarAsignacion(asignacionId) {
            Swal.fire({
                title: '¿Estás seguro de eliminar esta asignación de materia',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                didClose: function() {
                        location.reload(); // Actualizar la página
                    }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/asignaciones/materias/' + asignacionId,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log(response);
                            location.reload(); 
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }
    </script>
    
    <script>
        @if(session('success'))
            var successData = @json(session('success'));
            mostrar(successData.docente, successData.asignaciones);
        @endif
    
        function mostrar(docente, asignaciones) {
            var mensaje = '<strong>' + docente.nombres + ' ' + docente.paterno + ' ' + docente.materno + '</strong>' + ':<br><br>';
            for (var i = 0; i < asignaciones.length; i++) {
                var asignacion = asignaciones[i];
                mensaje += ' ' + asignacion.materia.sigla + ' ';
                mensaje += ' ' + asignacion.materia.materia + ' ';
                mensaje += ' - G ' + asignacion.grupo + '<br> ';
               // mensaje += asignacion.materia.sigla + ' - ' + asignacion.materia.materia + ' (' + asignacion.materia.carga_horaria + ' horas) - G' + asignacion.grupo + '<br>';
                mensaje += '<strong>Carga Horaria:</strong> ' + asignacion.carga_horaria_total + ' horas<br><br>';
            }
    
            Swal.fire({
                title: 'Materias asignadas',
                html: mensaje,
                icon: 'success'
            });
        }
    </script>

@endsection




