@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Lista de Usuarios</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary mb-3">+ Crear Nuevo Usuario</a>

    <table class="table table-bordered table-hover table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ ucfirst($usuario->rol) }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Seguro que querés eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $usuarios->links() }}
    </div>
@endsection
