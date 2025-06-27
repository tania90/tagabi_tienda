@extends('adminlte::page')

@section('title', 'Crear Cliente')

@section('content_header')
    <h1>Nuevo Cliente</h1>
@endsection

@section('content')
<form action="{{ route('clientes.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Nombre</label>
        <input name="nombre" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input name="email" type="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Teléfono</label>
        <input name="telefono" class="form-control">
    </div>
    <div class="form-group">
        <label>Dirección</label>
        <input name="direccion" class="form-control">
    </div>
    <button class="btn btn-success mt-3">Guardar</button>
</form>
@endsection
