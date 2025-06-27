@extends('adminlte::page')

@section('title', 'Detalle de Venta')

@section('content_header')
    <h1>Detalle de la Venta #{{ $venta->id }}</h1>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <p><strong>Cliente:</strong> {{ $venta->cliente->nombre }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</p>

        <hr>

        <h5>Productos vendidos:</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($venta->detalleVentas as $detalle)
            <tr>
                <td>{{ $detalle->producto->nombre }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>Gs {{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                <td>Gs {{ number_format($detalle->cantidad * $detalle->precio_unitario, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


        <div class="mt-3">
            <strong>Total de la venta:</strong> Gs {{ number_format($venta->total, 0, ',', '.') }}
        </div>

        <div class="mt-4">
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">← Volver al listado</a>
        </div>
    </div>
</div>

@endsection
