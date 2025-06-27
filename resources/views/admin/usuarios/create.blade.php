@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <h1>Registrar Nuevo Usuario</h1>
@endsection

@section('content')
    <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="form-group mt-2">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="form-group mt-2">
            <label>Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Rol:</label>
            <select name="rol" class="form-control" required>
                <option value="usuario" {{ old('rol') == 'usuario' ? 'selected' : '' }}>Usuario</option>
                <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
@endsection
