@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>📊 Panel de Control</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <x-adminlte-info-box title="Ventas del día" text="{{ number_format($ventasDelDia, 0, ',', '.') }} Gs" icon="fas fa-calendar-day" theme="success"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box title="Ventas del mes" text="{{ number_format($ventasDelMes, 0, ',', '.') }} Gs" icon="fas fa-calendar-alt" theme="info"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box title="Top Producto" text="{{ $productoTop ? $productoTop->nombre : 'Sin datos' }}" icon="fas fa-box" theme="warning"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box title="Total Clientes" text="{{ $totalClientes }}" icon="fas fa-users" theme="primary"/>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-3">
        <x-adminlte-info-box title="Total en Stock" text="{{ $totalProductos }}" icon="fas fa-boxes" theme="secondary"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box title="Cliente TOP comprador" text="{{ $clienteTop ? $clienteTop->nombre : 'Sin datos' }}" icon="fas fa-user-tie" theme="dark"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box title="Cliente con más puntos" text="{{ $clienteCanjeTop ? $clienteCanjeTop->nombre : 'Sin datos' }}" icon="fas fa-gift" theme="success"/>
    </div>
</div>

{{-- Gráfico de Ventas --}}
<div class="card mt-4">
    <div class="card-header border-0">
        <h3 class="card-title">Ventas</h3>
        <div class="card-tools">
            <a href="{{ route('ventas.index') }}" class="btn btn-sm btn-primary">Ver informe</a>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex">
            <p class="d-flex flex-column">
                <span class="text-bold text-lg">Gs. {{ number_format($totalMesActual, 0, ',', '.') }}</span>
                <span>Ventas a lo largo del tiempo</span>
            </p>
            <p class="ml-auto d-flex flex-column text-right">
                <span class="text-success">
                    <i class="fas fa-arrow-up"></i> {{ $variacionMes }}%
                </span>
                <span class="text-muted">Desde el mes pasado</span>
            </p>
        </div>
        <div class="position-relative mb-4">
            <canvas id="ventasChart" height="200"></canvas>
        </div>
        <div class="d-flex flex-row justify-content-end">
            <span class="mr-2">
                <i class="fas fa-square text-primary"></i> Monto Vendido
            </span>
            <span>
                <i class="fas fa-square text-gray"></i> Cantidad de Ventas
            </span>
        </div>
    </div>
</div>

{{-- Últimas 5 ventas --}}
<hr>
<h4>🧾 Últimas Ventas</h4>
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Productos</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ultimasVentas as $venta)
                    <tr>
                        <td>{{ $venta->cliente->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                        <td>
                            <ul>
                                @foreach($venta->detalleVentas as $detalle)
                                    <li>{{ $detalle->producto->nombre }} x {{ $detalle->cantidad }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ number_format($venta->total, 0, ',', '.') }} Gs</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No hay ventas registradas aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ventasChart');
    const ventasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($meses) !!},
            datasets: [
                {
                    label: 'Monto Vendido (Gs)',
                    backgroundColor: '#007bff',
                    data: {!! json_encode($totales) !!}
                },
                {
                    label: 'Cantidad de Ventas',
                    backgroundColor: '#d2d6de',
                    data: {!! json_encode($cantidades) !!}
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
