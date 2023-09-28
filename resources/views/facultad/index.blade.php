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
                                {{ __('Facultades') }}
                            </span>
                             <div class="float-right">
                                <a href="{{ route('facultades.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                            <table id="facultades_table" class="table table-hover text-nowrap">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>N°</th>
                                        <th>Facultad</th>
                                        <th>Autoridad</th>
                                        <th>telefono</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($facultades as $facultad)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{$facultad->facultad}}</td>
                                            <td>
                                                @if ($facultad->decano)
                                                {{$facultad->decano->nombres}} {{$facultad->decano->paterno}} {{$facultad->decano->materno}}
                                            @else
                                                Sin Autoridad
                                            @endif
                                            </td>
                                            <td>{{$facultad->telefono}}</td>
                                            <td>
                                                <form action="{{ route('facultades.destroy',$facultad->id_facultad) }}" method="POST">
                                                    <?php 
                                                    //<a class="btn btn-sm btn-primary " href="{{ route('docentes.show',$docente->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    ?>
                                                    <a class="btn btn-sm btn-success" href="{{ route('facultades.edit',$facultad->id_facultad) }}"><i class="fa fa-fw fa-edit"></i> </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta facultad?')">
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
    $('#facultades_table').DataTable( {
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