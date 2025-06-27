<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Tamano;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\Cliente;
use App\Models\Recompensa;

class ExportacionController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        $tamanos = Tamano::all();
        return view('exportaciones.index', compact('categorias', 'tamanos'));
    }

    public function exportarProductos(Request $request)
    {
        $query = Producto::with(['categoria', 'tamano']);

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('color')) {
            $query->where('color', 'like', '%' . $request->color . '%');
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('tamano_id')) {
            $query->where('tamano_id', $request->tamano_id);
        }

        $productos = $query->get();

        $filename = 'productos_exportados_' . now()->format('Ymd_His') . '.csv';
        $tempPath = storage_path('app/' . $filename);

        $writer = SimpleExcelWriter::create($tempPath)->addHeader([
            'Nombre',
            'Categoría',
            'Tamaño',
            'Color',
            'Cantidad',
            'Precio Costo',
            'Precio Venta',
        ]);

        foreach ($productos as $producto) {
            $writer->addRow([
                $producto->nombre,
                $producto->categoria->nombre ?? 'Sin categoría',
                $producto->tamano->nombre ?? 'Sin tamaño',
                $producto->color ?? '-',
                $producto->cantidad,
                $producto->precio_costo,
                $producto->precio_venta,
            ]);
        }

        $writer->close();

        return response()->download($tempPath)->deleteFileAfterSend();
    }

    public function exportarClientes(Request $request)
{
    $query = Cliente::query();

    // Filtro por nombre
    if ($request->filled('nombre')) {
        $query->where('nombre', 'like', '%' . $request->nombre . '%');
    }

    // Filtro por teléfono
    if ($request->filled('telefono')) {
        $query->where('telefono', 'like', '%' . $request->telefono . '%');
    }

    // Filtro por nivel (según monto_acumulado)
    if ($request->filled('nivel')) {
        $nivel = $request->nivel;
        $query->where(function ($q) use ($nivel) {
            if ($nivel === 'bronce') {
                $q->where('monto_acumulado', '<', 150000);
            } elseif ($nivel === 'plata') {
                $q->whereBetween('monto_acumulado', [150000, 499999]);
            } elseif ($nivel === 'oro') {
                $q->where('monto_acumulado', '>=', 500000);
            }
        });
    }

    $clientes = $query->get();

    $filename = 'clientes_exportados_' . now()->format('Ymd_His') . '.csv';
    $tempPath = storage_path('app/' . $filename);

    $writer = \Spatie\SimpleExcel\SimpleExcelWriter::create($tempPath)->addHeader([
        'Nombre',
        'Email',
        'Teléfono',
        'Dirección',
        'Monto Acumulado',
        'Nivel',
    ]);

    foreach ($clientes as $cliente) {
        $writer->addRow([
            $cliente->nombre,
            $cliente->email,
            $cliente->telefono ?? '-',
            $cliente->direccion ?? '-',
            $cliente->monto_acumulado,
            $cliente->monto_acumulado >= 500000 ? 'Oro' : ($cliente->monto_acumulado >= 150000 ? 'Plata' : 'Bronce'),
        ]);
    }

    $writer->close();

    return response()->download($tempPath)->deleteFileAfterSend();
}

public function exportarRecompensas(Request $request)
{
    $query = Recompensa::with('cliente');

    if ($request->filled('cliente')) {
        $query->whereHas('cliente', function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->cliente . '%');
        });
    }

    if ($request->filled('fecha_inicio')) {
        $query->whereDate('created_at', '>=', $request->fecha_inicio);
    }

    if ($request->filled('fecha_fin')) {
        $query->whereDate('created_at', '<=', $request->fecha_fin);
    }

    $recompensas = $query->get();

    $filename = 'recompensas_exportadas_' . now()->format('Ymd_His') . '.csv';
    $tempPath = storage_path('app/' . $filename);

    $writer = \Spatie\SimpleExcel\SimpleExcelWriter::create($tempPath)->addHeader([
        'Cliente',
        'Monto Acumulado',
        'Monto Canjeado',
        'Monto Disponible',
        'Fecha de Canje',
    ]);

    foreach ($recompensas as $r) {
        $cliente = $r->cliente;
        $totalGastado = $cliente->monto_acumulado ?? 0;
        $totalCanjeado = $cliente->recompensas->sum('monto_canjeado');
        $disponible = floor($totalGastado / 50000) * 5000 - $totalCanjeado;

        $writer->addRow([
            $cliente->nombre ?? 'Sin nombre',
            $totalGastado,
            $r->monto_canjeado,
            max(0, $disponible),
            $r->created_at->format('d/m/Y H:i'),
        ]);
    }

    $writer->close();

    return response()->download($tempPath)->deleteFileAfterSend();
}
}
