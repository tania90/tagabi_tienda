<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('admin.password.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with('error', 'La contraseña actual no es válida.');
        }

        $user = auth()->user();
        $user->password = bcrypt($request->password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada con éxito.');
    }
}
