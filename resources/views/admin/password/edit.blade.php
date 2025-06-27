@extends('adminlte::page')

@section('title', 'Cambiar Contraseña')

@section('content_header')
    <h1>Cambiar Contraseña</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Contraseña actual:</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Nueva contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Confirmar nueva contraseña:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
    </form>
@endsection
