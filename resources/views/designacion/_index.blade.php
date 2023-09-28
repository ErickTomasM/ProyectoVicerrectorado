@extends('adminlte::page')
@section('template_title')
    Facultad
@endsection

@section('content')
<h1>Asignar materias a docente</h1>
    <form action="/asignaciones" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_docente">Docente:</label>
            <select name="id_docente" id="id_docente" class="form-control">
                @foreach ($docentes as $docente)
                    <option value="{{ $docente->id_docente }}">{{ $docente->nombres }} {{ $docente->paterno }} {{ $docente->materno }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="materias">Materias:</label>
            <select name="materias[]" id="materias" multiple class="form-control">
                @foreach ($materias as $materia)
                    <option value="{{ $materia->id_materia }}">{{ $materia->sigla }} {{$materia->materia}}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection
