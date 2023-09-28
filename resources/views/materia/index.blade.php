@extends('adminlte::page')
@section('template_title')
    Docente
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Materia') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('materias.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="materias_table" class="table table-striped table-hover">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>id</th>     
                                        <th>Materia</th>                         
                                        <th>Sigla</th>
                                        <th>Horas Teoricas</th>
                                        <th>Horas Practicas</th>                            
                                        <th>carrera</th>
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
      
    $('#materias_table').DataTable( {
        processing: true,
        serverSide: true,
                "ajax": "{{url('/materia/json')}}",
                "columns": [
                    { data: 'id_materia', name: 'id_materia' },
                    { data: 'materia', name: 'materia' },
                    { data: 'sigla', name: 'sigla' },
                    { data: 'hrs_teoricas', name: 'hrs_teoricas' },
                    { data: 'hrs_practicas', name: 'hrs_practicas' },
                    { data: 'id_programa', name: 'id_programa' },
                   
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
    } );
    </script>
@endsection