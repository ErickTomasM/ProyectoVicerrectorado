@extends('adminlte::page')
@section('template_title')
    Crear Nuevo Docente
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Docente') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('docentes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Nuevo') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body table-responsive p-0">
                        <div class="table-responsive">
                            <table id="tabla-docentes" class= "table table-hover text-nowrap">
                               
                                <thead class= "bg-primary text-white" >
                                    <tr>
                                       <th>id</th>
                                        <th>Nombre</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        <th>ci</th>
                                        <th>Titulo</th>
                                        <th>tiempo</th>
                                        <th>estado</th>
                                    </tr>
                                </thead>
                               
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
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"> </script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"> </script>

    <script>
      
        $('#tabla-docentes').DataTable(
            {
                processing: true,
                serverSide: true,
                "ajax": "{{url('docente/json')}}",
                "columns": [
                    { data: 'id_docente', name: 'id_docente' },
                    { data: 'nombres', name: 'nombres' },
                    { data: 'paterno', name: 'paterno' },
                    { data: 'materno', name: 'materno' },
                    { data: 'ci', name: 'ci' },
                    { data: 'abre_titulo', name: 'abre_titulo' },
                    { data: 'tiempo', name: 'tiempo' },
                    { data: 'estado', name: 'estado' },
                   ],
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
            }
        );
       
    </script>
@endsection