@extends('adminlte::page')

@section('title', 'Histórico de Ventas')

@section('content_header')
    <h1>📦 Histórico de Ventas</h1>
@stop

@section('content')

    <form method="GET" action="{{ route('ventas.index') }}" class="mb-4">
        <div class="row">
            <div class="form-group col-md-3">
                <label>Cliente</label>
                <select name="cliente_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-3">
                <label>Desde</label>
                <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
            </div>

            <div class="form-group col-md-3">
                <label>Hasta</label>
                <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
            </div>

            <div class="form-group col-md-3 d-flex align-items-end">
                <button class="btn btn-primary mr-2">Filtrar</button>
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <div class="mb-3">
        <a href="{{ route('ventas.create') }}" class="btn btn-success">
            + Registrar Venta
        </a>
    </div>

    @if ($ventas->count())
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->cliente->nombre ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                        <td>{{ number_format($venta->total, 0, ',', '.') }} Gs</td>
                        <td>
                            <a href="{{ route('ventas.show', $venta) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('ventas.destroy', $venta) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Seguro que deseas eliminar esta venta?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $ventas->links() }}
    @else
        <div class="alert alert-info">No hay ventas registradas con estos filtros.</div>
    @endif

@stop
