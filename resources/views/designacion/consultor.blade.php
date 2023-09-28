@extends('adminlte::page')
@section('template_title')
Consultores
@endsection
@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-body p-0">
                <div class="card-header text-center">
                    <h2 class="mb-0">{{ $designacion->carrera->programa }}</h2>
                    <h3 class="mb-0">{{ $designacion->periodo }}/{{ $designacion->anio }}</h3>
                </div>
                <div class="container">
                    @foreach ($asignaciones as $docenteId => $asignacionesDocente)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>
                                        <span class="toggle-content toggle-link add-consultor"><i class="fas fa-plus-circle"></i></span>
                                        {{ $asignacionesDocente[0]->docente->nombres }} {{ $asignacionesDocente[0]->docente->paterno }} {{ $asignacionesDocente[0]->docente->materno }}
                                    </h5>
                                    <div>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#createModal{{ $asignacionesDocente[0]->docente->id_docente }}">
                                            <i class="fas fa-upload"></i>
                                            contrato
                                        </button>
                                        @foreach ($consultores as $consultor)
                                            @if ($consultor->id_docente == $asignacionesDocente[0]->docente->id_docente)
                                            <a class="btn btn-light" href="{{ asset('storage/designaciones/consultores/' . $consultor->contrato) }}" target="_blank">
                                                <i class="far fa-file-pdf fa-2x" style="color:red"></i> 
                                            </a>
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal{{ $consultor->id_consultor }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <ul class="docente-materias" style="display: none;">
                            @foreach ($asignacionesDocente as $asignacion)
                                <li>
                                    {{ $asignacion->materia->sigla }} {{ $asignacion->materia->materia }} Grupo: {{ $asignacion->grupo }}
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ventana modal para formulario -->
@foreach ($designacion->asignaciones->unique('id_docente') as $asignacion)
    <div class="modal fade" id="createModal{{ $asignacion->docente->id_docente }}" tabindex="-1" role="dialog" aria-labelledby="createModalLabel{{ $asignacion->docente->id_docente }}" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel{{ $asignacion->docente->id_docente }}">
                        {{ $asignacion->docente->nombres }}
                        {{ $asignacion->docente->paterno }}
                        {{ $asignacion->docente->materno }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'designaciones.consultor.guardar', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    {!! Form::hidden('id_designacion', $asignacion->id_designacion) !!}
                    {!! Form::hidden('id_docente', $asignacion->docente->id_docente) !!}
                    <div class="form-group">
                        {!! Form::label('contrato', 'Contrato') !!}
                        {!! Form::file('contrato', ['class' => 'form-control-file', 'accept' => 'application/pdf']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    {!! Form::submit('Guardar cambios', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endforeach

    <!-- fin de la ventana modal-->
      <!-- ventana modal edit-->
      @foreach ($consultores as $consultor)
      <div class="modal fade" id="editModal{{ $consultor->id_consultor }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $consultor->id_consultor }}" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="editModalLabel{{ $consultor->id_consultor }}">
                          {{ $consultor->docente->nombres }}
                          {{ $consultor->docente->paterno }}
                          {{ $consultor->docente->materno }}
                      </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      {!! Form::model($consultor, ['route' => ['designaciones.consultor.actualizar', $consultor->id_consultor], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                      {!! Form::hidden('id_designacion', $consultor->id_designacion) !!}
                      {!! Form::hidden('id_docente', $consultor->id_docente) !!}
                      <div class="form-group">
                          {!! Form::label('contrato', 'Contrato') !!}
                          {!! Form::file('contrato', ['class' => 'form-control-file', 'accept' => 'application/pdf']) !!}
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      {!! Form::submit('Guardar cambios', ['class' => 'btn btn-primary']) !!}
                  </div>
                  {!! Form::close() !!}
              </div>
          </div>
      </div>
  @endforeach
  

  
        <!-- fin de la ventana modal edit-->
@endsection
@section('css')
<style>
    .table {
        margin: 0 auto;
        width: 60%;
        font-size: 16px;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle !important;
    }

    .add-consultor {
        font-size: 25px;
        color: green;
        text-decoration: none;
    }

    .add-icon {
    font-size: 30px;
    margin-right: 5px;
}

</style>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        $(".toggle-content").click(function(){
            var ul = $(this).closest('.row').next(".docente-materias");
            ul.slideToggle();
            var icon = $(this).find("i");
            icon.toggleClass("fa-minus fa-plus-circle");
        });
    });
</script>
@endsection