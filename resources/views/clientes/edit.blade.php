@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1>Editar Cliente</h1>
@endsection

@section('content')
<form action="{{ route('clientes.update', $cliente) }}" method="POST">
    @csrf @method('PUT')
    <div class="form-group">
        <label>Nombre</label>
        <input name="nombre" value="{{ $cliente->nombre }}" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input name="email" type="email" value="{{ $cliente->email }}" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Teléfono</label>
        <input name="telefono" value="{{ $cliente->telefono }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Dirección</label>
        <input name="direccion" value="{{ $cliente->direccion }}" class="form-control">
    </div>
    <button class="btn btn-primary mt-3">Actualizar</button>
</form>
@endsection
