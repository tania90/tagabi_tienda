<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Recompensa;

class RecompensaController extends Controller
{
public function index(Request $request)
{
    $clientes = Cliente::with('recompensas')->get();

    // Filtros
    if ($request->filled('nombre')) {
        $clientes = $clientes->filter(function ($cliente) use ($request) {
            return stripos($cliente->nombre, $request->nombre) !== false;
        });
    }

    if ($request->filled('accion')) {
        $clientes = $clientes->filter(function ($cliente) use ($request) {
            $totalGastado = $cliente->monto_acumulado ?? 0;
            $totalCanjeado = $cliente->recompensas->sum('monto_canjeado');
            $puntosDisponibles = floor($totalGastado / 50000) * 5000 - $totalCanjeado;

            if ($request->accion === 'canjeable') {
                return $puntosDisponibles >= 5000;
            } elseif ($request->accion === 'nocanjeable') {
                return $puntosDisponibles < 5000;
            }

            return true;
        });
    }

    $historial = \App\Models\Recompensa::with('cliente')->latest()->get();

    return view('recompensas.index', compact('clientes', 'historial'));
}


    public function canjear(Cliente $cliente)
{
    // Calcular puntos disponibles
    $totalGastado = $cliente->monto_acumulado ?? 0;
    $totalCanjeado = $cliente->recompensas()->sum('monto_canjeado');
    $puntosDisponibles = floor($totalGastado / 50000) * 5000 - $totalCanjeado;

    if ($puntosDisponibles < 5000) {
        return back()->with('error', 'No hay recompensas suficientes para canjear.');
    }

    // Registrar nuevo canje
    Recompensa::create([
        'cliente_id' => $cliente->id,
        'monto_acumulado' => $recompensaGenerada, // <-- Este campo es obligatorio
        'monto_canjeado' => 5000,
    ]);

    return back()->with('success', '¡Se canjearon 5.000 Gs correctamente!');
}
}
