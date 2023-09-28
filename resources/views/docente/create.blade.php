@extends('adminlte::page')
@section('template_title')
    Crear Nuevo Docente
@endsection

@section('content')
<form action="/docentes" method="POST">
    @csrf

    <div class="form-row">

      <div class="form-group col-md-6">
        <label for="id_programa"> {{ $carrera->programa}} </label>
        <input type="text" class="form-control" id="id_programa" name="id_programa" value="{{ $carrera->id_programa }}" readonly>

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
        <label for="abre_titulo">Abreviatura del Título</label>
        <select class="form-control" id="abre_titulo" name="abre_titulo" value="{{$docente->abre_titulo}}">
          <option value="" >Seleccionar</option> <option>Lic.</option><option>M.SC. Lic.</option><option>Dr. Lic.</option><option>Ph.D. Lic.</option>
          <option>Ing.</option><option>M.SC. Ing.</option><option>Ph.D. Ing.</option>
          <option>Abog.</option><option>Dr. Abog</option><option>M.SC. Abog.</option>
          <option>Arq.</option>
          <option>Odt.</option>
          <option>Tec. Sup.</option>
          <option>Dr.</option><option>M.Sc. Dr.</option>
          <option>M.B.A</option>
        </select>
    </div>

    <div class="form-group col-md-6" >
        <label for="sexo">Genero</label>
        <select class="form-control" id="sexo" name="sexo" >
          <option value="" >Seleccionar</option>
          <option value="M">Masculino</option>
          <option value="F">Femenino</option>
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
      <label for="tipo_docente">Tipo de Docente</label>
      <select class="form-control" id="tipo_docente" name="tipo_docente">
        <option value="" >Seleccionar</option>
        <option value="Extraordinario Interino" @if($docente->tipo_docente == 'Docente Extraordinario Interino') selected @endif>Docente Extraordinario Interino</option>
        <option value="Extraordinario" @if($docente->tipo_docente == 'Docente Extraordinario') selected @endif>Docente Extraordinario</option>
        <option value="Ordinario Titular" @if($docente->tipo_docente == 'Docente Ordinario Titular') selected @endif>Docente Ordinario Titular</option>
        <option value="Ordinario" @if($docente->tipo_docente == 'Docente Ordinario') selected @endif>Docente Ordinario</option>
        <option value="Consultor" @if($docente->tipo_docente == 'Consultor de linea') selected @endif>Consultor de linea</option>
      </select>      
    </div>
  </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="/carreras" class="btn btn-danger">Cancelar</a>
  </form>
@endsection