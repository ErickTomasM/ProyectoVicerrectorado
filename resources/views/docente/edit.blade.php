@extends('adminlte::page')
@section('template_title')
    Crear Nuevo Docente
@endsection

@section('content')
<form action="/docentes/{{$docente->id_docente}}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-row">

      <div class="form-group col-md-6">
        {!! Form::label('id_programa', 'Carrera') !!}
        {!! Form::select('id_programa', $carreras, $docente->id_programa, ['class' => 'form-control']) !!}     
      </div>
      

    <div class="form-group col-md-6">
    </div>

      <div class="form-group col-md-6">
        <label for="Nombres">nombres</label>
        <input type="nombres" class="form-control" id="nombres" name="nombres" placeholder="nombres" value="{{$docente->nombres}}" >
      </div>

      <div class="form-group col-md-6">
        <label for="paterno">Apellido Paterno</label>
        <input type="paterno" class="form-control" id="paterno" name="paterno" placeholder="Apellido Paterno" value="{{$docente->paterno}}">
      </div>

      <div class="form-group col-md-6">
        <label for="materno">Apellido Materno</label>
        <input type="materno" class="form-control" id="maternoo" name="materno" placeholder="Apellido Materno" value="{{$docente->materno}}">
      </div>

      <div class="form-group col-md-6">
        <label for="ci">ci</label>
        <input type="ci" class="form-control" id="ci" name="ci" placeholder="ci" value="{{$docente->ci}}">
      </div>
      <div class="form-group col-md-6">
        <label for="abre_titulo">Abreviatura de título</label>
        <select class="form-control" id="abre_titulo" name="abre_titulo">
          <option value="">Seleccionar</option>
          <option value="Lic." {{ $docente->abre_titulo == 'Lic.' ? 'selected' : '' }}>Lic.</option>
          <option value="M.Sc. Lic." {{ $docente->abre_titulo == 'M.Sc. Lic.' ? 'selected' : '' }}>M.Sc. Lic.</option>
          <option value="Dr. Lic." {{ $docente->abre_titulo == 'Dr. Lic.' ? 'selected' : '' }}>Dr. Lic.</option>
          <option value="Ph.D. Lic." {{ $docente->abre_titulo == 'Ph.D. Lic.' ? 'selected' : '' }}>Ph.D. Lic.</option>
          <option value="Ing." {{ $docente->abre_titulo == 'Ing.' ? 'selected' : '' }}>Ing.</option>
          <option value="M.Sc. Ing." {{ $docente->abre_titulo == 'M.Sc. Ing.' ? 'selected' : '' }}>M.Sc. Ing.</option>
          <option value="Ph.D. Ing." {{ $docente->abre_titulo == 'Ph.D. Ing.' ? 'selected' : '' }}>Ph.D. Ing.</option>
          <option value="Abog." {{ $docente->abre_titulo == 'Abog.' ? 'selected' : '' }}>Abog.</option>
          <option value="Dr. Abog." {{ $docente->abre_titulo == 'Dr. Abog.' ? 'selected' : '' }}>Dr. Abog.</option>
          <option value="M.Sc. Abog." {{ $docente->abre_titulo == 'M.Sc. Abog.' ? 'selected' : '' }}>M.Sc. Abog.</option>
          <option value="Arq." {{ $docente->abre_titulo == 'Arq.' ? 'selected' : '' }}>Arq.</option>
          <option value="Odt." {{ $docente->abre_titulo == 'Odt.' ? 'selected' : '' }}>Odt.</option>
          <option value="Tec. Sup." {{ $docente->abre_titulo == 'Tec. Sup.' ? 'selected' : '' }}>Tec. Sup.</option>
          <option value="Dr." {{ $docente->abre_titulo == 'Dr.' ? 'selected' : '' }}>Dr.</option>
          <option value="M.Sc. Dr." {{ $docente->abre_titulo == 'M.Sc. Dr.' ? 'selected' : '' }}>M.Sc. Dr.</option>
          <option value="M.B.A." {{ $docente->abre_titulo == 'M.B.A.' ? 'selected' : '' }}>M.B.A.</option>
        </select>
      </div>

    <div class="form-group col-md-6">
      <label for="sexo">Sexo</label>
      <select class="form-control" id="sexo" name="sexo">
          <option value="M" {{ $docente->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
          <option value="F" {{ $docente->sexo == 'F' ? 'selected' : '' }}>Femenino</option>
      </select>
  </div>
  

    <div class="form-group col-md-6">
      <label for="tiempo">tiempo</label>
      <select class="form-control" id="tiempo" name="tiempo">
        <option value="" >Seleccionar</option>
          <option value="TH" @if($docente->tiempo == 'TH') selected @endif>Tiempo Horario</option>
          <option value="TC" @if($docente->tiempo == 'TC') selected @endif>Tiempo Completo</option>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="estado">estado</label>
      <select class="form-control" id="estado" name="estado">
          <option value="A" @if($docente->estado == 'A') selected @endif>Activo</option>
          <option value="B" @if($docente->estado == 'B') selected @endif>Inactivo</option>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="tipo_docente">Tipo de Docente</label>
      <select class="form-control" id="tipo_docente" name="tipo_docente">
        <option value="" >Seleccionar</option>
        <option value="Docente Extraordinario Interino" @if($docente->tipo_docente == 'Docente Extraordinario Interino') selected @endif>Docente Extraordinario Interino</option>
        <option value="Docente Extraordinario" @if($docente->tipo_docente == 'Docente Extraordinario') selected @endif>Docente Extraordinario</option>
        <option value="Docente Ordinario Titular" @if($docente->tipo_docente == 'Docente Ordinario Titular') selected @endif>Docente Ordinario Titular</option>
        <option value="Docente Ordinario" @if($docente->tipo_docente == 'Docente Ordinario') selected @endif>Docente Ordinario</option>
        <option value="Consultor de linea" @if($docente->tipo_docente == 'Consultor de linea') selected @endif>Consultor de linea</option>
      </select>
    </div>
  </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('carreras.showDocentes', $docente->id_programa) }}" class="btn btn-danger">Cancelar</a>

  </form>
@endsection