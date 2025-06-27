<div class="form-group">
    <label>Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre ?? '') }}" required>
</div>

<div class="form-group">
    <label>Código</label>
    <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $producto->codigo ?? '') }}" required>
</div>

<div class="form-group">
    <label>Cantidad</label>
    <input type="number" name="cantidad" class="form-control" value="{{ old('cantidad', $producto->cantidad ?? 0) }}" required>
</div>

<div class="form-group">
    <label>Stock mínimo</label>
    <input type="number" name="stock_minimo" class="form-control" value="{{ old('stock_minimo', $producto->stock_minimo ?? 1) }}">
</div>

<div class="form-group">
    <label>Color</label>
    <input type="text" name="color" class="form-control" value="{{ old('color', $producto->color ?? '') }}">
</div>

<div class="form-group">
    <label>Precio costo</label>
    <input type="number" step="0.01" name="precio_costo" class="form-control" value="{{ old('precio_costo', $producto->precio_costo ?? 0) }}" required>
</div>

<div class="form-group">
    <label>Precio venta</label>
    <input type="number" step="0.01" name="precio_venta" class="form-control" value="{{ old('precio_venta', $producto->precio_venta ?? 0) }}" required>
</div>

<div class="form-group">
    <label>Imagen</label>
    <input type="file" name="imagen" class="form-control">
    @if(!empty($producto->imagen))
        <img src="{{ asset('storage/'.$producto->imagen) }}" width="80" class="mt-2">
    @endif
</div>

<button type="submit" class="btn btn-success mt-3">{{ $modo ?? 'Guardar' }}</button>
<a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
