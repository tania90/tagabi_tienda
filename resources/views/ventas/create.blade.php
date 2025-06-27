@extends('adminlte::page')

@section('title', 'Registrar Venta')

@section('content_header')
    <h1>Registrar Venta</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('ventas.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="form-group col-md-6">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" class="form-control" required>
                <option value="">Seleccionar cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="fecha">Fecha de Venta</label>
            <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="form-group col-md-12">
            <label>Productos</label>
            <div id="productos-container"></div>
            <button type="button" class="btn btn-sm btn-success mt-2" onclick="agregarProducto()">+ Agregar Producto</button>
        </div>

        <div class="form-group col-md-6">
            <label for="tipo_descuento">Tipo de Descuento</label>
            <select name="tipo_descuento" id="tipo_descuento" class="form-control">
                <option value="">Sin descuento</option>
                <option value="porcentaje">Porcentaje (%)</option>
                <option value="monto">Monto (Gs)</option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="valor_descuento">Valor del Descuento</label>
            <input type="number" name="valor_descuento" id="valor_descuento" class="form-control" placeholder="Ej: 10 o 10000" min="0" step="any">
        </div>

        <div class="form-group col-md-6">
            <label for="total">Total:</label>
            <input type="text" id="total" name="total" class="form-control" readonly>
        </div>

        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-primary">Registrar Venta</button>
        </div>
    </div>
</form>
@stop

@section('js')
<script>
    let productos = @json($productos);
    let index = 0;

    function agregarProducto() {
        let row = `<div class="form-row mb-2" id="producto-${index}">
            <div class="col-md-4">
                <select name="productos[${index}][producto_id]" class="form-control" onchange="mostrarDatos(${index}, this)">
                    <option value="">Seleccionar producto</option>`;
        productos.forEach(p => {
            row += `<option value="${p.id}" data-precio="${p.precio_venta}" data-imagen="${p.imagen}">${p.nombre}</option>`;
        });
        row += `</select></div>
            <div class="col-md-2">
                <input type="number" name="productos[${index}][cantidad]" class="form-control" placeholder="Cantidad" min="1" onchange="calcularTotal()">
            </div>
            <div class="col-md-2">
                <input type="text" id="precio-${index}" class="form-control" placeholder="Precio" readonly>
            </div>
            <div class="col-md-2">
                <img id="imagen-${index}" src="" width="50" style="display:none;">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(${index})">Eliminar</button>
            </div>
        </div>`;

        document.getElementById('productos-container').insertAdjacentHTML('beforeend', row);
        index++;
    }

    function mostrarDatos(i, select) {
        const precio = select.options[select.selectedIndex].getAttribute('data-precio');
        const imagen = select.options[select.selectedIndex].getAttribute('data-imagen');

        document.getElementById(`precio-${i}`).value = precio;

        const imgEl = document.getElementById(`imagen-${i}`);
        if (imagen) {
            imgEl.src = `/storage/${imagen}`;
            imgEl.style.display = 'inline-block';
        } else {
            imgEl.style.display = 'none';
        }

        calcularTotal();
    }

    function eliminarProducto(i) {
        document.getElementById(`producto-${i}`).remove();
        calcularTotal();
    }

    function calcularTotal() {
        let total = 0;
        for (let i = 0; i < index; i++) {
            const producto = document.querySelector(`[name="productos[${i}][producto_id]"]`);
            const cantidad = document.querySelector(`[name="productos[${i}][cantidad]"]`);

            if (producto && cantidad && producto.value && cantidad.value) {
                const precio = producto.options[producto.selectedIndex].getAttribute('data-precio');
                total += parseFloat(precio) * parseInt(cantidad.value);
            }
        }

        const tipo = document.getElementById('tipo_descuento').value;
        const valor = parseFloat(document.getElementById('valor_descuento').value) || 0;

        if (tipo === 'porcentaje') {
            total -= total * (valor / 100);
        } else if (tipo === 'monto') {
            total -= valor;
        }

        total = total < 0 ? 0 : total;
        document.getElementById('total').value = total.toFixed(0);
    }

    document.getElementById('tipo_descuento').addEventListener('change', calcularTotal);
    document.getElementById('valor_descuento').addEventListener('input', calcularTotal);
</script>
@stop
