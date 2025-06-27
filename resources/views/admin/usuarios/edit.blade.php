@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@endsection

@section('content')
    <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="name" value="{{ $usuario->name }}" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Email:</label>
            <input type="email" name="email" value="{{ $usuario->email }}" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Rol:</label>
            <select name="rol" class="form-control" required>
                <option value="usuario" {{ $usuario->rol == 'usuario' ? 'selected' : '' }}>Usuario</option>
                <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Actualizar</button>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
@endsection
