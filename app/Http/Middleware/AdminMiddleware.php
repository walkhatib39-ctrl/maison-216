<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Restreint l'accès aux utilisateurs admin.
     * - Si non authentifié: redirection vers login
     * - Si authentifié mais non admin: 403
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!($user->is_admin ?? false)) {
            abort(403, 'Accès refusé');
        }

        return $next($request);
    }
}
