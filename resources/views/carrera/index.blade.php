@extends('adminlte::page')

@section('template_title')
    Facultad
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Carreras') }}
                            </span>
                             <div class="float-right">
                                @can('ver vicerrectorado')
                                <a href="{{ route('carreras.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Nueva Carrera') }}
                                </a>
                                @endcan

                              </div>
                              
                        </div>
                    </div>
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                    
                    <div class="card-body">
                        <div class="table-responsive">
                           
                                <table id="carreras_table" class="table table-striped table-hover">
                                    <thead  class="bg-primary text-white">
                                        <tr>
                                            <th>N°</th>
                                            <th>Carrera</th>
                                            <th>telefono</th>
                                            
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($carreras as $carrera)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{$carrera->programa}}</td>
                                                <td>{{$carrera->telefono}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm btn-primary" href="{{ route('carreras.showMaterias', $carrera->id_programa) }}">
                                                            <i class="fas fa-book"></i>
                                                            <span class="d-none d-md-inline">Plan de estudios</span>
                                                        </a>
                                                    
                                                        <a class="btn btn-sm btn-info" href="{{ route('carreras.apoyo', $carrera->id_programa) }}">
                                                            <i class="fas fa-book"></i>
                                                            <span class="d-none d-md-inline">Materias de apoyo</span>
                                                        </a>
                                                        
                                                        <a class="btn btn-sm btn-warning" href="{{ route('carreras.showDocentes', $carrera->id_programa) }}">
                                                            <i class="fas fa-chalkboard-teacher"></i>
                                                            <span class="d-none d-md-inline">Ver Docentes</span>
                                                        </a>
                                                        
                                                        @can('ver vicerrectorado')
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                                                                    <i class="fas fa-cogs"></i>
                                                                    <span class="d-none d-md-inline">Opciones</span>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="{{ route('carreras.edit', $carrera->id_programa) }}">
                                                                        <i class="fas fa-edit"></i> Editar Carrera
                                                                    </a>
                                                                    <form action="{{ route('carreras.destroy', $carrera->id_programa) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta carrera?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="fas fa-trash"></i> Eliminar Carrera
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endcan
                                                    </div>
                                                    
                                                    
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
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"> </script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"> </script>

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
@endsection