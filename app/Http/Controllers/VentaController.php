<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::all();
        $query = Venta::with('cliente')->orderBy('fecha_venta', 'desc');

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->fecha_hasta);
        }

        $ventas = $query->paginate(10)->withQueryString();

        return view('ventas.index', compact('ventas', 'clientes'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $totalVenta = 0;
            $totalProductos = 0;

            // Calcular el total antes de guardar
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['producto_id']);
                $totalVenta += $producto->precio_venta * $item['cantidad'];
                $totalProductos += $item['cantidad'];
            }

            // Aplicar descuento si existe
            $tipoDescuento = $request->tipo_descuento;
            $valorDescuento = $request->valor_descuento ?? 0;
            $descuento = 0;

            if ($tipoDescuento === 'porcentaje') {
                $descuento = $totalVenta * ($valorDescuento / 100);
            } elseif ($tipoDescuento === 'monto') {
                $descuento = $valorDescuento;
            }

            $montoFinal = max($totalVenta - $descuento, 0);

            // Guardar la venta ya con total incluido
            $venta = new Venta();
            $venta->cliente_id = $request->cliente_id;
            $venta->fecha_venta = $request->fecha ?? now();
            $venta->tipo_descuento = $tipoDescuento;
            $venta->valor_descuento = $valorDescuento;
            $venta->total = $montoFinal;
            $venta->save();

            // Guardar detalles de venta y actualizar stock
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['producto_id']);

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                ]);

                // Restar del stock
                $producto->cantidad -= $item['cantidad'];
                $producto->save();
            }

            // Actualizar cliente
            $cliente = Cliente::find($venta->cliente_id);
            $cliente->monto_acumulado += $montoFinal;
            $cliente->total_productos_comprados += $totalProductos;
            $cliente->save();

            // Calcular recompensa
$recompensaGenerada = floor($montoFinal / 50000) * 5000;

$cliente->recompensas()->create([
    'monto_acumulado' => $recompensaGenerada,
    'monto_canjeado' => 0,
]);

            DB::commit();
            return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit(Venta $venta)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::all();
        $venta->load('detalleVentas.producto');
        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    public function update(Request $request, Venta $venta)
    {
        // Opcional: lógica de edición de venta
    }

    public function show(Venta $venta)
    {
        $venta->load('cliente', 'detalleVentas.producto');
        return view('ventas.show', compact('venta'));
    }

public function destroy(Venta $venta)
{
    DB::beginTransaction();

    try {
        $cliente = $venta->cliente;

        // Cargar detalles y productos
        $venta->load('detalleVentas.producto');

        $totalProductos = 0;
foreach ($venta->detalleVentas as $detalle) {
    $totalProductos += $detalle->cantidad;

    if ($detalle->producto) {
        \Log::info("Reponiendo stock para producto ID {$detalle->producto->id} - cantidad sumada: {$detalle->cantidad}");
        $detalle->producto->cantidad += $detalle->cantidad;
        $detalle->producto->save();
    } else {
        \Log::warning("Producto no encontrado para detalle ID {$detalle->id}");
    }
}


        // Revertir acumulados del cliente
        $cliente->monto_acumulado = max($cliente->monto_acumulado - $venta->total, 0);
        $cliente->total_productos_comprados = max($cliente->total_productos_comprados - $totalProductos, 0);
        $cliente->save();

        // Eliminar recompensas generadas por esta venta
        $recompensasAsociadas = floor($venta->total / 50000) * 5000;
        if ($recompensasAsociadas > 0) {
            $cliente->recompensas()
                ->where('monto_acumulado', $recompensasAsociadas)
                ->latest()
                ->take(1)
                ->delete();
        }

        // Eliminar detalles
        $venta->detalleVentas()->delete();

        // Eliminar venta
        $venta->delete();

        DB::commit();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada y datos del cliente revertidos correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
    }
}


}
