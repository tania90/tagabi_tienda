<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Tamano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request)
{
    $categorias = Categoria::all();
    $tamanos = Tamano::all();

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

    $productos = $query->paginate(10);

    return view('productos.index', compact('productos', 'categorias', 'tamanos'));
}

    public function create()
    {
        $categorias = Categoria::all();
        $tamanos = Tamano::all();
        return view('productos.create', compact('categorias', 'tamanos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string|max:100|unique:productos,codigo',
            'cantidad' => 'required|integer|min:0',
            'color' => 'nullable|string|max:100',
            'precio_costo' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categoria_id' => 'nullable|exists:categorias,id',
            'tamano_id' => 'nullable|exists:tamanos,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data);

        return redirect()->route('productos.index')->with('success', 'Producto agregado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $tamanos = Tamano::all();
        return view('productos.edit', compact('producto', 'categorias', 'tamanos'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string|max:100|unique:productos,codigo,' . $producto->id,
            'cantidad' => 'required|integer|min:0',
            'color' => 'nullable|string|max:100',
            'precio_costo' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categoria_id' => 'nullable|exists:categorias,id',
            'tamano_id' => 'nullable|exists:tamanos,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }
}
