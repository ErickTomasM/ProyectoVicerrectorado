@extends('adminlte::page')

@section('template_title')
    proveído
@endsection

@section('content')
    <div class="container text-center">
        <label class="h4 text-info">{{ $carrera->programa }} </label>
    </div>
    <div class="card-header text-center">
        <h2 class="mb-0">{{ $carrera->programa }}</h2>
        <h3 class="mb-0">{{ $periodo }}/{{ $gestion }}</h3>
    </div>
     <br>

    <table id="reporte" class="table table-striped table-hover">
        <thead class="bg-primary text-white">
            <tr>
                <th>N°</th>
                <th>Resolución</th>
                <th>fecha</th>
                <th>Dictamen</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($designaciones as $designacion)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $designacion->resolucion }}</td>
                    <td>{{ $designacion->gestion }}</td>
                    <td>{{ $designacion->dictamen }} </td>
                    <td>
                        <a class="btn btn-sm btn-pdf" href="{{ route('proveido.pdf', ['id' => $designacion->id_designacion]) }}" target="_blank">
                            <i class="far fa-file-pdf fa-2x" style="color: red;"></i>
                            Generar PDF
                        </a>
                        
                    </td>
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
