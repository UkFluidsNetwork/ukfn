<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

final class RedirectIfNotModerator
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
        $isModerator = Auth::guest()
          ? false
          : (Auth::user()->isModerator() || Auth::user()->isAdmin());

        if (!$isModerator) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }

}
