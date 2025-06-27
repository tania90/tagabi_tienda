@extends('adminlte::page')

@section('title', 'Exportaciones')

@section('content_header')
    <h1>📤 Módulo de Exportaciones</h1>
@stop

@section('content')
    {{-- Exportar Productos --}}
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Exportar Productos</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('exportaciones.productos') }}">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="nombre">Nombre del Producto</label>
                        <input type="text" name="nombre" class="form-control" value="{{ request('nombre') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="color">Color</label>
                        <input type="text" name="color" class="form-control" value="{{ request('color') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="categoria_id">Categoría</label>
                        <select name="categoria_id" class="form-control">
                            <option value="">-- Todas --</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="tamano_id">Tamaño</label>
                        <select name="tamano_id" class="form-control">
                            <option value="">-- Todos --</option>
                            @foreach ($tamanos as $tamano)
                                <option value="{{ $tamano->id }}" {{ request('tamano_id') == $tamano->id ? 'selected' : '' }}>
                                    {{ $tamano->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Exportar Productos (.csv)
                </button>
            </form>
        </div>
    </div>

    {{-- Exportar Clientes --}}
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Exportar Clientes</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('exportaciones.clientes') }}">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="nombre">Nombre del Cliente</label>
                        <input type="text" name="nombre" class="form-control" value="{{ request('nombre') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ request('telefono') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nivel">Nivel de Cliente</label>
                        <select name="nivel" class="form-control">
                            <option value="">-- Todos --</option>
                            <option value="bronce" {{ request('nivel') == 'bronce' ? 'selected' : '' }}>🥉 Bronce</option>
                            <option value="plata" {{ request('nivel') == 'plata' ? 'selected' : '' }}>🥈 Plata</option>
                            <option value="oro" {{ request('nivel') == 'oro' ? 'selected' : '' }}>🥇 Oro</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Exportar Clientes (.csv)
                </button>
            </form>
        </div>
    </div>

    {{-- Exportar Recompensas --}}
    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Exportar Recompensas</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('exportaciones.recompensas') }}">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="cliente">Nombre del Cliente</label>
                        <input type="text" name="cliente" class="form-control" value="{{ request('cliente') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="fecha_inicio">Desde</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="fecha_fin">Hasta</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Exportar Recompensas (.csv)
                </button>
            </form>
        </div>
    </div>
@stop
