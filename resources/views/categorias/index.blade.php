@extends('adminlte::page')

@section('title', 'Categorías')

@section('content_header')
    <h1>📂 Categorías de Productos</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nueva Categoría
    </a>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->nombre }}</td>
                            <td class="text-right">
                                <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar esta categoría?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No hay categorías registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $categorias->links() }}
        </div>
    </div>
@stop
