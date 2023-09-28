@extends('adminlte::page')

@section('template_title')
    Plan de Estudios
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="container text-center">
                            <label class="h4 text-info">{{$carrera->programa}}</label>
                        </div>
                        <a href="{{ route('materias.create', $carrera->id_programa) }}" class="btn btn-primary mr-2">
                            {{ __('Nuevo') }}
                        </a>
                        
                        
                        <a href="{{ route('carreras.index') }}" class="btn btn-danger">
                            {{ __('Regresar') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="tabla-materias" class="table table-striped table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>N°</th>
                            <th>Sigla</th>
                            <th>Asignatura</th>     
                            <th>Total Horas</th>                                                                  
                           
                            <th>Apoyo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materias as $materia)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{$materia->sigla}}</td>
                            <td>
                                {{ $materia->materia }}
                                <br>
                                <small class="text-muted">Hrs. Teóricas: {{ $materia->hrs_teoricas }} - Hrs. Prácticas: {{ $materia->hrs_practicas }}</small>
                            </td>
                            <td>{{$materia->hrs_teoricas + $materia->hrs_practicas}}</td>
                         
                            <td>
                                @if(count($materia->apoyo) > 0)
                                    Apoyo
                                @endif
                            </td>
                            
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('apoyo.carrera', $materia->id_materia) }}" class="btn btn-primary mr-2">
                                        <i class="fas fa-plus"></i> Materias de Apoyo
                                    </a>
                                    @if(count($materia->apoyo) > 0)
                                    <form action="{{ route('apoyo.eliminar', $materia->id_materia) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta materia de apoyo?')">
                                            <i class="fa fa-fw fa-trash"></i> Apoyo
                                        </button>
                                    </form>
                                        @endif
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-success" href="{{ route('materias.edit', $materia->id_materia) }}">
                                            <i class="fa fa-fw fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ route('materias.destroy', $materia->id_materia) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta materia?')">
                                                <i class="fa fa-fw fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                       
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>

<script>
$(document).ready(function() {
    $('#tabla-materias').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por Página",
            "zeroRecords": "No se encontró ningún registro",
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

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '{{ session('success') }}',
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
    });
</script>
@endif


@endsection
