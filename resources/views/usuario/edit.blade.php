@extends('adminlte::page')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('title', 'dashboard')
@section('content_header')
@stop
@section('content')
    @if(session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
    @endif
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Información del usuario</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <p class="mb-0"><strong>Nombre:</strong> {{ $usuario->name }}</p>
                </div>
                <div class="col-12 col-sm-6">
                    <p class="mb-0"><strong>Correo electrónico:</strong> {{ $usuario->email }}</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <h2>Roles</h2>
                </div>
            </div>
            {!! Form::model($usuario, ['route' => ['usuarios.update', $usuario], 'method' => 'put']) !!}
            <div class="row">
                @foreach($roles as $role)
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="{{ $role->name }}" {{ $usuario->roles->pluck('id')->contains($role->id) ? 'checked' : '' }}>
                        <label class="form-check-label btn btn-outline-success" for="{{ $role->name }}">{{ $role->name }}</label>
                    </div>
                </div>
                @endforeach
            </div>
            <div>
                {!! Form::submit('Asignar', ['class' => 'btn btn-success mt-4']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection


