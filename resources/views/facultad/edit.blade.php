@extends('adminlte::page')
@section('template_title')
    Facultad
@endsection

@section('content')
<h1>Editar Registro</h1>
                                        
<form action="/facultades/{{$facultad->id_facultad}}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group col-md-6">
      <label for="facultad">facultad</label>
      <input type="facultad" class="form-control" id="facultad" name="facultad" placeholder="facultad" value="{{$facultad->facultad}}" >
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="telefono">telefono</label>
        <input type="telefono" class="form-control" id="telefono" name="telefono" placeholder="telefono" value="{{$facultad->telefono}}">
      </div>
      <div class="form-group col-md-6">
        <label for=email">email</label>
        <input type=email" class="form-control" id=emaili" name="email" placeholder="email" value="{{$facultad->email}}">
      </div>

      <div class="form-group col-md-6">
        <label for="decano">Decano</label>
        <select name="id_docente" id="decano" class="form-control select2">
            <option value="">Seleccionar</option>
            @foreach($docentes as $docente)
                <option value="{{$docente->id_docente}}" {{$docente->id_docente == $facultad->id_docente ? 'selected' : ''}}>
                    <span class="column-2">{{$docente->carrera}}</span>:: 
                    <span class="column-1">{{$docente->nombres}} {{$docente->paterno}} {{$docente->materno}}</span>
                </option>
            @endforeach
        </select>
    </div>
      <div class="form-group col-md-6">
        <label for="autoridad">Cargo</label>
        <select name="autoridad" id="autoridad" class="form-control">
          <option value="">Seleccionar</option>
          @if ($facultad->id_facultad == 23)
            <option value="Vicerrector" {{ $facultad->autoridad == 'Vicerrector' ? 'selected' : '' }}>Vicerrector</option>
            <option value="Subrogante" {{ $facultad->autoridad == 'Subrogante' ? 'selected' : '' }}>Vicerrector Subrogante</option>
          @else
            <option value="Titular" {{ $facultad->autoridad == 'Titular' ? 'selected' : '' }}>Decano Titular</option>
            <option value="Interino" {{ $facultad->autoridad == 'Interino' ? 'selected' : '' }}>Decano Interino</option>
          @endif
        </select>
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