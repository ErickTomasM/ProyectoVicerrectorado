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
                        <div class="d-flex justify-content-between align-items-center">
                          <h3 class="m-0">{{ __('Docente') }}</h3>
                          <div>
                            <a href="{{ route('docentes.create', $carrera->id_programa) }}" class="btn btn-primary mr-2">
                                {{ __('Nuevo') }}
                            </a>
                            
                            <a href="{{ route('carreras.index') }}" class="btn btn-danger">
                              {{ __('Regresar') }}
                            </a>
                          </div>
                        </div>
                      </div>
                      
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="container text-center">
                        <label class="h4 text-info">{{ $carrera->programa }} </label>
                    </div> 
                    <div class="card-body table-responsive p-0">
                        <div class="table-responsive">
                            <table id="tabla-docentes" class= "table table-hover text-nowrap">
                               
                                <thead class= "bg-primary text-white" >
                                    <tr>
                                        <th>N°</th>
                                        <th></th>
                                        <th>Docente</th> 
                                        <th>ci</th>
                                        <th>tiempo</th>
                                        <th>Dedicación</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($docentes as $docente)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td> {{$docente->abre_titulo}}</td>
                                        <td> {{$docente->nombres}}
                                             {{$docente->paterno}}
                                             {{$docente->materno}}
                                        </td>
                                        <td> {{$docente->ci}}</td>
                                        <td> {{$docente->tiempo}}</td>
                                        <td> {{$docente->tipo_docente}}</td>
                                        
                                        
                                        <td>
                                            
                                                <form action="{{ route('docentes.destroy',$docente->id_docente) }}" method="POST">
                                                    <?php 
                                                    //<a class="btn btn-sm btn-primary " href="{{ route('docentes.show',$docente->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    ?>
                                                    <a class="btn btn-sm btn-success" href="{{ route('docentes.edit',$docente->id_docente) }}"><i class="fa fa-fw fa-edit"></i> </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta carrera?')">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                    </button>
                                                </form>
                                               
                                                
                                           
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
     $('#tabla-docentes').DataTable( {
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