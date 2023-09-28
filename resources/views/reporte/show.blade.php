@extends('adminlte::page')

@section('template_title')
    Reporte
@endsection

@section('content')
    <div class="container text-center">
        <label class="h4 text-info">{{ $carrera->programa }} </label>
    </div>
    <div class="card-header text-center">
        <h2 class="mb-0">{{ $carrera->programa }}</h2>
        <h3 class="mb-0">{{ $periodo }}/{{ $gestion }}</h3>
    </div>

    <div>
        <a class="btn btn-sm btn-pdf" href="{{ route('reporte.pdf', ['id_programa' => $carrera->id_programa, 'periodo' => $periodo, 'gestion' => $gestion]) }}" target="_blank">
            <i class="far fa-file-pdf fa-2x" style="color: red;"></i>
            Generar PDF
        </a>
    </div>  <br>

    <table id="reporte" class="table table-striped table-hover">
        <thead class="bg-primary text-white">
            <tr>
                <th>N°</th>
                <th>CI</th>
                <th>Nombres</th>
                <th>Dedicación</th>
                <th>Materia</th>
                <th>Sigla</th>
                <th>Grupo</th>
                <th>Horas</th>
                <th>Según</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asignaciones as $asignacion)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $asignacion->docente->ci }}</td>
                    <td>{{ $asignacion->docente->nombres }} {{ $asignacion->docente->paterno }} {{ $asignacion->docente->materno }}</td>
                    <td>{{ $asignacion->docente->tipo_docente }}</td>
                    <td>{{ $asignacion->materia->materia }}</td>
                    <td>{{ $asignacion->materia->sigla }}</td>
                    <td>{{ $asignacion->grupo }}</td>
                    <td>{{ $asignacion->materia->hrs_teoricas + $asignacion->materia->hrs_practicas }}</td>
                    <td>Resol: {{ $asignacion->designacion->resolucion }} Dict: {{ $asignacion->designacion->dictamen }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"> </script>
    <script>
        $(document).ready(function() {
            $('#reporte').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ Registros por Página",
                    "zeroRecords": "No se encontró ningún Registro",
                    "info": "Mostrando la Página _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(Se filtraron _MAX_ registros totales)",
                    "search": "Buscar",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
@endsection
