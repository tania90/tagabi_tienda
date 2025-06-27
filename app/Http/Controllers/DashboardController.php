<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Recompensa;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Totales simples
        $ventasDelDia = Venta::whereDate('created_at', Carbon::today())->sum('total');
        $ventasDelMes = Venta::whereMonth('created_at', now()->month)->sum('total');
        $totalClientes = Cliente::count();
        $totalProductos = Producto::sum('cantidad');

        // Producto más vendido
        $productoTop = Producto::withCount('detalleVentas')
            ->orderByDesc('detalle_ventas_count')
            ->first();

        // Cliente que más gastó
        $clienteTop = Cliente::orderByDesc('monto_acumulado')->first();

        // Cliente con más puntos para canjear
        $clientes = Cliente::with('recompensas')->get();
        $clienteCanjeTop = null;
        $puntosMaximos = 0;

        foreach ($clientes as $cliente) {
            $gastado = $cliente->monto_acumulado ?? 0;
            $canjeado = $cliente->recompensas->sum('monto_canjeado');
            $disponible = floor($gastado / 50000) * 5000 - $canjeado;

            if ($disponible > $puntosMaximos) {
                $puntosMaximos = $disponible;
                $clienteCanjeTop = $cliente;
            }
        }

        // Últimas 5 ventas
        $ultimasVentas = Venta::with(['cliente', 'detalleVentas.producto'])
            ->latest()
            ->take(5)
            ->get();

        // Datos para el gráfico (ventas del año actual por mes)
        $ventasPorMes = Venta::selectRaw('MONTH(created_at) as mes, SUM(total) as total, COUNT(*) as cantidad')
            ->whereYear('created_at', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = [];
        $totales = [];
        $cantidades = [];

        for ($i = 1; $i <= 12; $i++) {
            $meses[] = strtoupper(Carbon::create()->month($i)->locale('es')->translatedFormat('M'));
            $mesData = $ventasPorMes->firstWhere('mes', $i);
            $totales[] = $mesData ? $mesData->total : 0;
            $cantidades[] = $mesData ? $mesData->cantidad : 0;
        }

        // Cálculo de variación entre mes actual y anterior
        $mesActual = now()->month;
        $totalMesActual = $ventasPorMes->firstWhere('mes', $mesActual)?->total ?? 0;
        $totalMesAnterior = $ventasPorMes->firstWhere('mes', $mesActual - 1)?->total ?? 0;
        $variacionMes = $totalMesAnterior > 0
            ? number_format((($totalMesActual - $totalMesAnterior) / $totalMesAnterior) * 100, 1)
            : '100';

        return view('dashboard', compact(
            'ventasDelDia',
            'ventasDelMes',
            'productoTop',
            'totalClientes',
            'totalProductos',
            'clienteTop',
            'clienteCanjeTop',
            'ultimasVentas',
            'meses',
            'totales',
            'cantidades',
            'totalMesActual',
            'variacionMes'
        ));
    }
}
