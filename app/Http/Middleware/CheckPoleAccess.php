<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPoleAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Admin has access to everything
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        if ($user->hasRole('gs')) {
            $gs = $user->gestionnaireStag;
            
            // Example: if there's a 'pole' parameter in the route
            $pole = $request->route('pole');
            if ($pole && $pole->id !== $gs->pole_id) {
                abort(403, 'Accès non autorisé à ce pôle.');
            }

            // Example: if there's a 'groupe' parameter
            $groupe = $request->route('groupe');
            if ($groupe && $groupe->pole_id !== $gs->pole_id) {
                abort(403, 'Accès non autorisé à ce groupe.');
            }

            // Example: if there's a 'stagiaire' parameter
            $stagiaire = $request->route('stagiaire');
            if ($stagiaire && $stagiaire->groupe->pole_id !== $gs->pole_id) {
                abort(403, 'Accès non autorisé à ce stagiaire.');
            }
        }

        return $next($request);
    }
}
