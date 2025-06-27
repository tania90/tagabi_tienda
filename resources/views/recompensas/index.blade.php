@extends('adminlte::page')

@section('title', 'Recompensas')

@section('content_header')
    <h1>🎁 Recompensas de Clientes</h1>
@stop

@section('content')
    {{-- Mensajes flash --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-header">Filtros</div>
        <div class="card-body">
            <form method="GET" action="{{ route('recompensas.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre del Cliente</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ request('nombre') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="accion">Estado</label>
                        <select name="accion" id="accion" class="form-control">
                            <option value="">-- Todos --</option>
                            <option value="canjeable" {{ request('accion') == 'canjeable' ? 'selected' : '' }}>Con puntos disponibles</option>
                            <option value="nocanjeable" {{ request('accion') == 'nocanjeable' ? 'selected' : '' }}>Sin puntos disponibles</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2 text-right">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de recompensas --}}
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Clientes con puntos acumulados</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Total Gastado</th>
                        <th>Total Canjeado</th>
                        <th>Puntos Disponibles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        @php
                            $totalGastado = $cliente->monto_acumulado ?? 0;
                            $totalCanjeado = $cliente->recompensas->sum('monto_canjeado');
                            $disponibles = floor($totalGastado / 50000) * 5000 - $totalCanjeado;
                        @endphp
                        <tr>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ number_format($totalGastado, 0, ',', '.') }} Gs</td>
                            <td>{{ number_format($totalCanjeado, 0, ',', '.') }} Gs</td>
                            <td><strong>{{ number_format($disponibles, 0, ',', '.') }} Gs</strong></td>
                            <td>
                                @if($disponibles >= 5000)
                                    <form action="{{ route('recompensas.canjear', $cliente->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Canjear 5.000 Gs</button>
                                    </form>
                                @else
                                    <span class="text-muted">No disponible</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No hay clientes con recompensas aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Historial de canjes --}}
    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">📜 Historial de Canjes</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Monto Canjeado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historial as $canje)
                        <tr>
                            <td>{{ $canje->cliente->nombre }}</td>
                            <td>{{ number_format($canje->monto_canjeado, 0, ',', '.') }} Gs</td>
                            <td>{{ $canje->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No hay canjes registrados aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
