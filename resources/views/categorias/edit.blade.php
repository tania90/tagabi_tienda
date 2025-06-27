@extends('adminlte::page')

@section('title', 'Editar Categoría')

@section('content_header')
    <h1>✏️ Editar Categoría</h1>
@stop

@section('content')
    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre de la Categoría</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $categoria->nombre) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Volver</a>
    </form>
@stop
