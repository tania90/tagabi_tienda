@extends('adminlte::page')

@section('title', 'Editar Producto')

@section('content_header')
    <h1>✏️ Editar Producto</h1>
@stop

@section('content')
    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="form-group col-md-4">
                <label for="nombre">Nombre del producto</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>

            <div class="form-group col-md-4">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $producto->codigo) }}">
            </div>

            <div class="form-group col-md-4">
                <label for="cantidad">Stock</label>
                <input type="number" name="cantidad" class="form-control" value="{{ old('cantidad', $producto->cantidad) }}" required min="0">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="color">Color</label>
                <input type="text" name="color" class="form-control" value="{{ old('color', $producto->color) }}">
            </div>

            <div class="form-group col-md-4">
                <label for="precio_costo">Precio de costo (Gs)</label>
                <input type="number" name="precio_costo" class="form-control" value="{{ old('precio_costo', $producto->precio_costo) }}" required step="0.01">
            </div>

            <div class="form-group col-md-4">
                <label for="precio_venta">Precio de venta (Gs)</label>
                <input type="number" name="precio_venta" class="form-control" value="{{ old('precio_venta', $producto->precio_venta) }}" required step="0.01">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="categoria_id">Categoría</label>
                <select name="categoria_id" class="form-control">
                    <option value="">-- Selecciona una categoría --</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>Imagen actual</label><br>
                @if ($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="imagen" width="100">
                @else
                    <p class="text-muted">Sin imagen</p>
                @endif
            </div>

            <div class="form-group col-md-4">
                <label for="imagen">Cambiar Imagen</label>
                <input type="file" name="imagen" class="form-control-file">
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Actualizar Producto
            </button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@stop
