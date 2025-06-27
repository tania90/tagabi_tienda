@extends('adminlte::page')

@section('title', 'Agregar Producto')

@section('content_header')
    <h1>🛒 Agregar Nuevo Producto</h1>
@stop

@section('content')
    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="form-group col-md-4">
                <label for="nombre">Nombre del producto</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="form-group col-md-4">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" class="form-control">
            </div>

            <div class="form-group col-md-4">
                <label for="cantidad">Stock</label>
                <input type="number" name="cantidad" class="form-control" required min="0">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="color">Color</label>
                <input type="text" name="color" class="form-control">
            </div>

            <div class="form-group col-md-4">
                <label for="tamano_id">Tamaño</label>
                <select name="tamano_id" class="form-control">
                    <option value="">-- Selecciona un tamaño --</option>
                    @foreach ($tamanos as $tamano)
                        <option value="{{ $tamano->id }}" {{ old('tamano_id') == $tamano->id ? 'selected' : '' }}>
                            {{ $tamano->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="categoria_id">Categoría</label>
                <select name="categoria_id" class="form-control">
                    <option value="">-- Selecciona una categoría --</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="precio_costo">Precio de costo (Gs)</label>
                <input type="number" name="precio_costo" class="form-control" required step="0.01">
            </div>

            <div class="form-group col-md-6">
                <label for="precio_venta">Precio de venta (Gs)</label>
                <input type="number" name="precio_venta" class="form-control" required step="0.01">
            </div>
        </div>

        <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" class="form-control-file">
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Producto
            </button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@stop
