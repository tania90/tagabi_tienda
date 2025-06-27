@extends('adminlte::page')

@section('title', 'Perfil del Cliente')

@section('content_header')
    <h1>👤 Detalles del Cliente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">{{ $cliente->nombre }}</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Email:</strong> {{ $cliente->email }}</li>
                <li class="list-group-item"><strong>Teléfono:</strong> {{ $cliente->telefono }}</li>
                <li class="list-group-item"><strong>Dirección:</strong> {{ $cliente->direccion }}</li>
                <li class="list-group-item"><strong>Total de Productos Comprados:</strong> {{ $cliente->total_productos_comprados }}</li>
                <li class="list-group-item"><strong>Monto Acumulado:</strong> {{ number_format($cliente->monto_acumulado, 0, ',', '.') }} Gs</li>
                <li class="list-group-item">
                    <strong>Nivel de Fidelización:</strong>
                    @if($cliente->monto_acumulado > 500000)
                        <span class="badge badge-warning">✨ Oro</span>
                    @elseif($cliente->monto_acumulado > 150000)
                        <span class="badge badge-secondary">🥈 Plata</span>
                    @else
                        <span class="badge badge-bronze">🥉 Bronce</span>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    {{-- RECOMPENSAS --}}
    <div class="card mt-4">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">🎁 Recompensas del Cliente</h5>
        </div>
        <div class="card-body">
@php
    $acumulado = $cliente->recompensas->sum('monto_acumulado');
    $canjeado = $cliente->recompensas->sum('monto_canjeado');
    $disponible = $acumulado - $canjeado;
@endphp


            <ul class="list-group">
                <li class="list-group-item"><strong>Puntos acumulados:</strong> {{ number_format($acumulado, 0, ',', '.') }} Gs</li>
                <li class="list-group-item"><strong>Puntos canjeados:</strong> {{ number_format($canjeado, 0, ',', '.') }} Gs</li>
                <li class="list-group-item"><strong>Puntos disponibles:</strong> {{ number_format($disponible, 0, ',', '.') }} Gs</li>
            </ul>

            <small class="text-muted mt-2 d-block">Por cada 50.000 Gs en compras acumulás 5.000 Gs como recompensa.</small>
        </div>
    </div>

    {{-- HISTORIAL DE COMPRAS --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5>🧾 Historial de Compras</h5>
        </div>
        <div class="card-body p-0">
            @if ($cliente->ventas->count() > 0)
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Productos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cliente->ventas as $venta)
                            <tr>
                                <td>
    <a href="{{ route('ventas.show', $venta->id) }}">
        {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}
    </a>
</td>
                                <td>{{ number_format($venta->total, 0, ',', '.') }} Gs</td>
                                <td>
                                    <ul class="mb-0 pl-3">
                                        @if($venta->detalleVentas)
    @foreach($venta->detalleVentas as $detalle)
        <li>{{ $detalle->producto->nombre }} (x{{ $detalle->cantidad }})</li>
    @endforeach
@else
    <li><em>Sin detalles</em></li>
@endif

                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-3">
                    <p class="text-muted mb-0">Este cliente aún no ha realizado compras.</p>
                </div>
            @endif
        </div>
    </div>
@stop
