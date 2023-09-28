
@extends('adminlte::page')
@section('template_title')
    Crear Nueva Carrera
@endsection

@section('content')
<h1>Crear Registro</h1>
                        
<form action="/carreras" method="POST">
    @csrf
    <div class="form-row">

        <div class="form-group col-md-6">
            {!! Form::label('id_facultad', 'Facultad') !!}
            {!! Form::select('id_facultad', $facultades, null, ['class' => 'form-control']) !!}     
        </div>

        <div class="form-group col-md-6">
            
            
        </div>

      <div class="form-group col-md-6">
        <label for="id_programa">id_programa</label>
        <input type="id_programa" class="form-control" id="id_programa" name="id_programa" placeholder="introduzca una abreviatura de la carrera con 3 letras ejem. ADM "  >
      </div>

      <div class="form-group col-md-6">
        <label for="programa">programa</label>
        <input type="programa" class="form-control" id="programa" name="programa" placeholder="programa" >
      </div>

       

      <div class="form-group col-md-6">
        <label for=telefono">telefono</label>
        <input type=telefono" class="form-control" id=telefonoi" name="telefono" placeholder="telefono" >
      </div>
      <div class="form-group col-md-6">
        <label for=email">email</label>
        <input type=email" class="form-control" id=emaili" name="email" placeholder="email" >
      </div>
      <div class="form-group col-md-6">
        
        
      </div>
    </div>

     
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="/carreras" class="btn btn-danger">Cancelar</a>
  </form>
@endsection