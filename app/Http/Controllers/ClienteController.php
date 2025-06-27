<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
public function index(Request $request)
{
    $query = Cliente::query();

    // Filtro por nombre
    if ($request->filled('nombre')) {
        $query->where('nombre', 'like', '%' . $request->nombre . '%');
    }

    // Filtro por nivel
    if ($request->filled('nivel')) {
        $query->where(function ($q) use ($request) {
            if ($request->nivel === 'bronce') {
                $q->where('monto_acumulado', '<', 150000);
            } elseif ($request->nivel === 'plata') {
                $q->where('monto_acumulado', '>=', 150000)->where('monto_acumulado', '<', 500000);
            } elseif ($request->nivel === 'oro') {
                $q->where('monto_acumulado', '>=', 500000);
            }
        });
    }

    $clientes = $query->paginate(10);
    return view('clientes.index', compact('clientes'));
}


    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:clientes,email',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        Cliente::create($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito.');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        $cliente->update($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado.');
    }

    public function historial($id)
{
    $cliente = Cliente::with('ventas.detalles.producto')->findOrFail($id);

    return view('clientes.historial', compact('cliente'));
}

public function show($id)
{
    $cliente = Cliente::with(['ventas.detalleVentas.producto', 'recompensas'])->findOrFail($id);
    return view('clientes.show', compact('cliente'));
}

public function recompensas()
{
    return $this->hasMany(\App\Models\Recompensa::class);
}
}
