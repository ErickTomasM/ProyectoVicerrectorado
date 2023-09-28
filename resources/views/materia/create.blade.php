@extends('adminlte::page')
@section('template_title')
    Carrera
@endsection

@section('content')
<form action="{{ route('materias.store') }}" method="POST">
  @csrf
  <div class="form-row">
      <div class="form-group col-md-6">
          <label for="id_programa">Carrera</label>
          <select class="form-control" id="id_programa" name="id_programa">
              @foreach($carreras as $id => $carrera)
              <option value="{{ $id }}">{{ $carrera }}</option>
              @endforeach
          </select>
      </div>

      <div class="form-group col-md-6">
          <!-- Aquí puedes agregar más campos o elementos de formulario si es necesario -->
      </div>

      <div class="form-group col-md-6">
          <label for="sigla">Sigla</label>
          <input type="text" class="form-control" id="sigla" name="sigla" placeholder="Sigla">
      </div>

      <div class="form-group col-md-6">
          <label for="materia">Materia</label>
          <input type="text" class="form-control" id="materia" name="materia" placeholder="Materia">
      </div>

      <div class="form-group col-md-6">
          <label for="hrs_practicas">Horas Prácticas</label>
          <input type="number" class="form-control" id="hrs_practicas" name="hrs_practicas" placeholder="Horas Prácticas">
      </div>

      <div class="form-group col-md-6">
          <label for="hrs_teoricas">Horas Teóricas</label>
          <input type="number" class="form-control" id="hrs_teoricas" name="hrs_teoricas" placeholder="Horas Teóricas">
      </div>
  </div>
  <button type="submit" class="btn btn-primary">Guardar</button>
  <a href="/carreras" class="btn btn-danger">Cancelar</a>
</form>

@endsection