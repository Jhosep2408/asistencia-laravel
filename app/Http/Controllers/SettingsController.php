<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Obtener configuración del usuario o usar valores por defecto
        $settings = $user->settings ?? [
            'language' => 'es',
            'theme' => 'light',
            'notifications' => true,
            'email_notifications' => true
        ];

        return view('settings.show', [
            'user' => $user,
            'settings' => (object)$settings,
            'title' => 'Configuración'
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'language' => 'required|in:es,en,fr,pt',
            'theme' => 'required|in:light,dark,system',
            'notifications' => 'sometimes',
            'email_notifications' => 'sometimes'
        ]);

        // Convertir checkboxes a booleanos
        $validated['notifications'] = $request->has('notifications');
        $validated['email_notifications'] = $request->has('email_notifications');

        // Actualizar configuración del usuario
        $user->settings = $validated;
        $user->save();

        // Guardar en sesión para uso inmediato
        Session::put('theme', $validated['theme']);
        Session::put('language', $validated['language']);

        // Aplicar idioma inmediatamente
        App::setLocale($validated['language']);

        return back()->with('success', 'Configuración actualizada correctamente.');
    }
}