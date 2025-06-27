@extends('adminlte::page')

@section('title', 'Inventario')

@section('content_header')
    <h1>📦 Inventario de Productos</h1>
@stop

@section('content')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Registrar Producto
        </a>
        <div class="alert alert-info mb-0">
            <strong>Total en stock:</strong> {{ $productos->sum('cantidad') }}
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Tamaño</th>
                    <th>Cantidad</th>
                    <th>Color</th>
                    <th>Precio Costo</th>
                    <th>Precio Venta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td>
                            @if ($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="imagen" width="50">
                            @else
                                <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td>{{ $producto->tamano->nombre ?? 'Sin tamaño' }}</td>
                        <td>{{ $producto->cantidad }}</td>
                        <td>{{ $producto->color ?? '-' }}</td>
                        <td>Gs. {{ number_format($producto->precio_costo, 0, ',', '.') }}</td>
                        <td>Gs. {{ number_format($producto->precio_venta, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás segura de eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-muted text-center py-4">
                            <i class="fas fa-box-open fa-2x d-block mb-2"></i>
                            Aún no hay productos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $productos->withQueryString()->links() }}
    </div>
@stop
