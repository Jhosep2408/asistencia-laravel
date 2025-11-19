<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Método para mostrar el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Método para procesar el login - CORREGIDO
    public function login(Request $request)
    {
        // Validación más específica
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El formato del correo electrónico no es válido',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres'
        ]);

        // Limpiar el email de espacios en blanco
        $credentials['email'] = trim($credentials['email']);

        // Intentar autenticación con más opciones
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // SOLO redirigir al dashboard de admin
            return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido al sistema!');
        }

        // Si falla la autenticación, mostrar error específico
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.'
        ])->withInput($request->except('password'));
    }

    // Método para cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Has cerrado sesión correctamente.');
    }
}