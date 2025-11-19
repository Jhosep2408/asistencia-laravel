<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ThemeAndLanguageMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener configuración del usuario autenticado
        if (Auth::check()) {
            $user = Auth::user();
            $settings = $user->settings ?? [];
            
            // Tema
            $theme = $settings['theme'] ?? Session::get('theme', 'light');
            Session::put('theme', $theme);
            view()->share('currentTheme', $theme);
            
            // Idioma
            $language = $settings['language'] ?? Session::get('language', 'es');
            Session::put('language', $language);
            App::setLocale($language);
            view()->share('currentLanguage', $language);
            
        } else {
            // Para usuarios no autenticados
            $theme = Session::get('theme', 'light');
            $language = Session::get('language', 'es');
            
            Session::put('theme', $theme);
            Session::put('language', $language);
            App::setLocale($language);
            
            view()->share('currentTheme', $theme);
            view()->share('currentLanguage', $language);
        }

        return $next($request);
    }
}