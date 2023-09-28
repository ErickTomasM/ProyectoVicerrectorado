@extends('adminlte::page')
@section('template_title')
    Facultad
@endsection

@section('content')
<h1>Crear Registro</h1>
                                        
<form action="/facultades" method="POST">
  @csrf
  <div class="form-group col-md-12">
    <label for="facultad">Facultad</label>
    <input type="facultad" class="form-control" id="facultad" name="facultad" placeholder="Facultad">
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="telefono">Teléfono</label>
      <input type="telefono" class="form-control" id="telefono" name="telefono" placeholder="Teléfono">
    </div>

    <div class="form-group col-md-6">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Email">
    </div>

    <div class="form-group col-md-6">
      <label for="decano">Decano</label>
      <select name="id_docente" id="decano" class="form-control select2">
          <option></option> 
          @foreach($docentes as $docente)
          <option class="select-option" value="{{$docente->id_docente}}">
              <span class="column-2">{{$docente->carreras->id_programa}}</span>:: 
              <span class="column-1">{{$docente->nombres}} {{$docente->paterno}} {{$docente->materno}}</span>
          </option>
          @endforeach
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="autoridad">Autoridad</label>
      <select name="autoridad" id="autoridad" class="form-control">
        <option value="">Seleccionar</option>
        <option value="Titular">Decano Titular</option>
        <option value="Interino">Decano Interino</option>
      </select>
    </div>

  </div>

  <button type="submit" class="btn btn-primary">Guardar</button>
  <a href="/facultades" class="btn btn-danger">Cancelar</a>
</form>

@endsection

@section('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
      $('.select2').select2();
  });
</script>

@endsection