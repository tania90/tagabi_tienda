@extends('adminlte::page')

@section('title', 'Historial de Compras')

@section('content_header')
    <h1>Historial de compras de {{ $cliente->nombre }}</h1>
@stop

@section('content')
    @if ($cliente->ventas->isEmpty())
        <div class="alert alert-info">Este cliente aún no tiene compras registradas.</div>
    @else
        @foreach ($cliente->ventas as $venta)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Fecha:</strong> {{ $venta->fecha }} |
                    <strong>Total:</strong> {{ number_format($venta->total, 0, ',', '.') }} Gs |
                    <strong>Recompensa:</strong> 
                    @php
                        $recompensa = floor($venta->total / 50000) * 10000;
                    @endphp
                    {{ number_format($recompensa, 0, ',', '.') }} Gs
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($venta->detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->producto->nombre }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>{{ number_format($detalle->precio_unitario, 0, ',', '.') }} Gs</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">⬅️ Volver</a>
@stop
