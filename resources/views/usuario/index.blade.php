@extends('adminlte::page')
@section('css')
<link rel="stylesheet" href="{{ asset('css/prueba.css') }}">
@endsection
@section('title', 'Usuarios')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="container text-center">
                <label class="h3 text-black">Listar Usuarios</label>
            </div>
            <div class="box-tools pull-right">
                
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->roles->pluck('name')->implode(', ') }}</td>
                            <td>
                                <a href="{{route('usuarios.edit', $usuario->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-cog"></i> Asignar</a>

                                </a>
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?')">Eliminar</button>
                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
