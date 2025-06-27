<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * Mostrar formulario para cambiar contraseña.
     */
    public function edit()
    {
        return view('auth.passwords.change');
    }

    /**
     * Actualizar la contraseña del usuario autenticado.
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        // Actualizar contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('dashboard')->with('success', '¡Contraseña actualizada con éxito!');
    }
}
