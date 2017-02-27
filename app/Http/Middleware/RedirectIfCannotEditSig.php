<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

final class RedirectIfCannotEditSig
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $sigId = isset($request->route()->parameters()['id']) ? $request->route()->parameters()['id'] : null;
        
        $isAdmin = (Auth::guest() || $sigId === null) ? false : (Auth::user()->canEditSig($sigId));
        if (!$isAdmin) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
