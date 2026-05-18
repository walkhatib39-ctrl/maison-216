<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WorkshopAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('workshop.login');
        }

        $user = Auth::user();

        if (! ($user->is_workshop_user || $user->is_admin)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('workshop.login')
                ->withErrors(['email' => 'Accès atelier non autorisé.']);
        }

        return $next($request);
    }
}
