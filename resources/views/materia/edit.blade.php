@extends('adminlte::page')
@section('template_title')
@section('content')

<form action="/materias/{{$materia->id_materia}}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-row">
      
      <div class="form-group col-md-6">
        {!! Form::label('id_programa', 'Carrera') !!}     
        {!! Form::select('id_programa', $carreras , $materia->id_programa, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group col-md-6">   
      </div>

      <div class="form-group col-md-6">
        <label for="sigla">sigla</label>
        <input type="sigla" class="form-control" id="sigla" name="sigla" placeholder="sigla" value="{{$materia->sigla}}" >
      </div>

      <div class="form-group col-md-6">
        <label for="materia"> materia</label>
        <input type="materia" class="form-control" id="materia" name="materia" placeholder="materia" value="{{$materia->materia}}">
      </div>

      <div class="form-group col-md-6">
        <label for="hrs_practicas">hrs_practicas</label>
        <input type="hrs_practicas" class="form-control" id="hrs_practicas" name="hrs_practicas" placeholder="hrs_practicas" value="{{$materia->hrs_practicas}}">
      </div>

      <div class="form-group col-md-6">
        <label for="hrs_teoricas">hrs_teoricas</label>
        <input type="hrs_teoricas" class="form-control" id="hrs_teoricas" name="hrs_teoricas" placeholder="hrs_teoricas" value="{{$materia->hrs_teoricas}}">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="/carreras" class="btn btn-danger">Cancelar</a>
  </form>
@endsection