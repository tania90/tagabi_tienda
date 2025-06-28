@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">📊 Panel de Control</h1>

    <div class="row mb-3">
        <div class="col-md-3"><strong>Ventas del día:</strong> {{ number_format($ventasDelDia ?? 0, 0, ',', '.') }} Gs</div>
        <div class="col-md-3"><strong>Ventas del mes:</strong> {{ number_format($ventasDelMes ?? 0, 0, ',', '.') }} Gs</div>
        <div class="col-md-3"><strong>Top Producto:</strong> {{ $productoTop->nombre ?? 'Sin datos' }}</div>
        <div class="col-md-3"><strong>Total Clientes:</strong> {{ $totalClientes ?? 0 }}</div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3"><strong>Total en Stock:</strong> {{ $totalProductos ?? 0 }}</div>
        <div class="col-md-3"><strong>Cliente TOP comprador:</strong> {{ $clienteTop->nombre ?? 'Sin datos' }}</div>
        <div class="col-md-3"><strong>Cliente con más puntos:</strong> {{ $clienteCanjeTop->nombre ?? 'Sin datos' }}</div>
    </div>

    <hr>

    <h4 class="mt-4">📈 Ventas del mes</h4>
    <p><strong>Total:</strong> Gs. {{ number_format($totalMesActual ?? 0, 0, ',', '.') }}</p>
    <p><strong>Variación respecto al mes pasado:</strong> {{ $variacionMes ?? 0 }}%</p>

    <canvas id="ventasChart" height="200" style="max-width:100%; margin-top:20px;"></canvas>

    <hr>

    <h4 class="mt-4">🧾 Últimas Ventas</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Productos</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ultimasVentas ?? [] as $venta)
                    <tr>
                        <td>{{ $venta->cliente->nombre ?? 'Sin nombre' }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_venta ?? now())->format('d/m/Y') }}</td>
                        <td>
                            <ul class="pl-3">
                                @foreach($venta->detalleVentas ?? [] as $detalle)
                                    <li>{{ $detalle->producto->nombre ?? 'Producto eliminado' }} x {{ $detalle->cantidad ?? '?' }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ number_format($venta->total ?? 0, 0, ',', '.') }} Gs</td>
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
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ventasChart');
    const ventasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($meses ?? []) !!},
            datasets: [
                {
                    label: 'Monto Vendido (Gs)',
                    backgroundColor: '#007bff',
                    data: {!! json_encode($totales ?? []) !!}
                },
                {
                    label: 'Cantidad de Ventas',
                    backgroundColor: '#d2d6de',
                    data: {!! json_encode($cantidades ?? []) !!}
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
