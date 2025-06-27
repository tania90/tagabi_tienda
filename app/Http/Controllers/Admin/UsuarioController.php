<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Listar todos los usuarios
    public function index()
    {
        $usuarios = User::paginate(10);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('admin.usuarios.create');
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'rol'      => 'required|in:admin,usuario',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'rol'      => $request->rol,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    // Mostrar formulario de edición
    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    // Actualizar usuario
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'rol'   => 'required|in:admin,usuario',
        ]);

        $usuario->update([
            'name'  => $request->name,
            'email' => $request->email,
            'rol'   => $request->rol,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar usuario
    public function destroy(User $usuario)
    {
        if (auth()->id() == $usuario->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
