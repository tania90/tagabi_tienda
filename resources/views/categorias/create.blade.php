@extends('adminlte::page')

@section('title', 'Categoría')

@section('content_header')
    <h1>{{ isset($categoria) ? 'Editar' : 'Nueva' }} Categoría</h1>
@stop

@section('content')
    <form action="{{ isset($categoria) ? route('categorias.update', $categoria) : route('categorias.store') }}" method="POST">
        @csrf
        @if(isset($categoria))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nombre">Nombre de la Categoría</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $categoria->nombre ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-success">
            {{ isset($categoria) ? 'Actualizar' : 'Guardar' }}
        </button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Volver</a>
    </form>
@stop
