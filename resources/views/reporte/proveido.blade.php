@extends('adminlte::page')
@section('template_title')
Proveido
@endsection
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 align = "center" >Proveído</h3>
                      <form action="{{ route('proveido.vista') }}" method="POST">
                        @csrf
                        <div class="form-group">
                          <label for="carrera">Carrera:</label>
                          <select name="id_carrera" id="carrera" class="form-control">
                            @foreach($carreras as $carrera)
                              <option value="{{ $carrera->id_programa }}">{{$carrera->programa}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="periodo">Carrera:</label>
                          <select name="periodo" id="periodo" class="form-control">
                              <option value="Gestión Académica">Gestión Académica</option>
                              <option value="Semestre I">Semestre I</option>
                              <option value="Semestre II">Semestre II</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="gestion">Gestión:</label>
                          <select name="gestion" id="gestion" class="form-control">
                            @foreach($designaciones->pluck('anio')->unique() as $anio)
                                <option value="{{ $anio }}" {{ $anio == date('Y') ? 'selected' : '' }}>{{ $anio }}</option>
                            @endforeach
                          </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ver Reporte</button>
                        <button type="reset" class="btn btn-secondary">Limpiar</button>
                      </form>
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection
