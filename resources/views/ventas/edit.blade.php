@extends('adminlte::page')

@section('title', 'Editar Venta')

@section('content_header')
    <h1>Editar Venta</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('ventas.update', $venta->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="form-group col-md-6">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" class="form-control" required>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $cliente->id == $venta->cliente_id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $venta->fecha->format('Y-m-d') }}" required>
        </div>
    </div>

    <hr>
    <h5>Productos</h5>
    <div id="productos-container">
        @foreach ($venta->detalleVentas as $index => $detalle)
        <div class="row mb-3 producto-item">
            <div class="form-group col-md-4">
                <label>Producto</label>
                <select name="productos[{{ $index }}][producto_id]" class="form-control producto-select" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_venta }}" data-imagen="{{ asset('storage/'.$producto->imagen) }}"
                            {{ $detalle->producto_id == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Cantidad</label>
                <input type="number" name="productos[{{ $index }}][cantidad]" class="form-control" value="{{ $detalle->cantidad }}" required>
            </div>

            <div class="form-group col-md-2">
                <label>Precio Unitario</label>
                <input type="text" class="form-control precio-unitario" value="{{ number_format($detalle->precio_unitario, 0, ',', '.') }}" readonly>
            </div>

            <div class="form-group col-md-2">
                <label>Imagen</label><br>
                <img src="{{ asset('storage/'.$detalle->producto->imagen) }}" alt="imagen" width="50">
            </div>
        </div>
        @endforeach
    </div>

    <hr>
    <h5>Descuento</h5>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="tipo_descuento">Tipo de Descuento</label>
            <select name="tipo_descuento" class="form-control">
                <option value="">Sin descuento</option>
                <option value="porcentaje" {{ $venta->tipo_descuento == 'porcentaje' ? 'selected' : '' }}>Porcentaje (%)</option>
                <option value="monto" {{ $venta->tipo_descuento == 'monto' ? 'selected' : '' }}>Monto (Gs)</option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="valor_descuento">Valor del Descuento</label>
            <input type="number" name="valor_descuento" class="form-control" value="{{ $venta->valor_descuento }}">
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-2">Actualizar Venta</button>
</form>

@stop
