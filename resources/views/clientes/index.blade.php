@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('clientes.create') }}" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Nuevo Cliente
        </a>
        <div class="alert alert-info mb-0">
            <strong>Total de clientes:</strong> {{ $clientes->total() }}
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($clientes->count())
                <div class="table-responsive">
                    <table class="table table-hover table-striped m-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Gasto Total</th>
                                <th>Nivel</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->nombre }}</td>
                                    <td>{{ $cliente->email }}</td>
                                    <td>{{ $cliente->telefono }}</td>
                                    <td>{{ $cliente->direccion }}</td>
                                    <td>{{ number_format($cliente->monto_acumulado, 0, ',', '.') }} Gs</td>
                                    <td>
                                        @if ($cliente->monto_acumulado >= 500000)
                                            <span class="badge badge-warning">🥇 Oro</span>
                                        @elseif ($cliente->monto_acumulado >= 150000)
                                            <span class="badge badge-secondary">🥈 Plata</span>
                                        @else
                                            <span class="badge badge-dark">🥉 Bronce</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-outline-info" title="Historial">
                                            <i class="fas fa-history"></i>
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este cliente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-3">
                    <p class="mb-0">No hay clientes registrados.</p>
                </div>
            @endif
        </div>
        <div class="card-footer">
            {{ $clientes->withQueryString()->links() }}
        </div>
    </div>
@stop
