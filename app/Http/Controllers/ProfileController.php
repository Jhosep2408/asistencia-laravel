<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Agrega esta línea

class ProfileController extends Controller
{
    /**
     * Mostrar el perfil del usuario
     */ 
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Actualizar el perfil del usuario
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return redirect()->route('profile.show')
                ->with('success', 'Perfil actualizado correctamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Actualizar la contraseña del usuario
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'La contraseña actual es incorrecta.')
                ->withInput();
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return redirect()->route('profile.show')
                ->with('success', 'Contraseña actualizada correctamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al cambiar la contraseña: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Método edit si lo necesitas (parece que ya existe)
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    /**
 * Método about - si es necesario
 */
public function about()
{
    return view('profile.about'); // o la vista que corresponda
}
public function privacy()
{
    return view('profile.privacy'); // Asegúrate de que esta vista exista
}

}