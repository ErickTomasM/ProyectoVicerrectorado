@extends('adminlte::page')

@section('template_title')
    Materias de Apoyo
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Materias de Apoyo') }}
                            </span>
                             <div class="float-right">
                               agregar
                              </div>
                              
                        </div>
                    </div>
                 
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="carreras_table" class="table table-striped table-hover">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>N°</th>
                                        <th>Materia</th>
                                        <th>Sigla</th>
                                        <th>Carrera</th>
                                      
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($apoyo as $ap)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $ap->materia->materia }}</td>
                                            <td>{{ $ap->materia->sigla }}</td>
                                            <td>
                                                {{ $ap->programa->programa}}
                                            </td>
                                           

                                            <td>
                                                <a class="btn btn-info" href="{{ route('apoyo.guardar', ['carrera' => $id, 'programa' => $ap->carrera->id_programa, 'id_materia' => $ap->materia->id_materia]) }}">Agregar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"> </script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

    <script>
       $(document).ready(function() {
    $('#carreras_table').DataTable( {
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
    

    @if (session('swal_success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: "{{ session('swal_success') }}",
        });
    </script>
@endif

@if (session('swal_info'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Información',
            text: "{{ session('swal_info') }}",
        });
    </script>
@endif

@endsection