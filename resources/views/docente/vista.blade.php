@extends('adminlte::page')
@section('template_title')
    Crear Nuevo Docente
@endsection

@section('content')
   
                            <table id="docentes_table" class="table table-hover text-nowrap">
                               
                                <thead class="bg-primary text-white">
                               
                                        
                                        <th>Nombre</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        
                                       
                                   
                                </thead>
                               
                            </table>
              
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#docentes_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: { url:
                '{{ route('json') }}' },
                columns: [
                    { data: 'nombres', name: 'nombres' },
                    { data: 'paterno', name: 'paterno' },
                    { data: 'materno', name: 'materno' }
                  
                ]
            });
        });
    </script>
@stop


