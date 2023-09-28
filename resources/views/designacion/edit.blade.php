@extends('adminlte::page')

@section('template_title')
    Designacion
@endsection

@section('content')
   

   <!-- MODAL EDITAR DESIGNACION -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Designacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model($designacion, ['route' => ['designaciones.update', $designacion->id_designacion], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                        {!! Form::label('resolucion', 'Resolucion') !!}
                        {!! Form::number('resolucion', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('dictamen', 'Dictamen') !!}
                        {!! Form::number('dictamen', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('periodo', 'Periodo') !!}
                        {!! Form::select('periodo', ['Gestión Académica' => 'Gestión Académica', 'Semestre I' => 'Semestre I', 'Semestre II' => 'Semestre II'], null, ['class' => 'form-control']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('gestion', 'Fecha') !!}
                        {!! Form::date('gestion', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('documento', 'Documento PDF') !!}
                        {!! Form::file('documento', ['class' => 'form-control-file', 'accept' => 'application/pdf']) !!}
                    </div>
                   
                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>



    @section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    @endsection
    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"> </script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"> </script>
    
      
    @endsection
@endsection

