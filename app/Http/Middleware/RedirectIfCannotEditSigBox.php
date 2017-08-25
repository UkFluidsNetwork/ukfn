<?php

namespace App\Http\Middleware;

use Auth;
use App\Sigbox;
use Closure;

final class RedirectIfCannotEditSigBox
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
        $boxId = isset($request->route()->parameters()['id'])
                 ? $request->route()->parameters()['id']
                 : null;

        if ($boxId !== null) {
            $box = Sigbox::findOrFail($boxId);
            $sigId = $box->sig_id;
        } else {
            $sigId = null;
        }

        $isAdmin = (Auth::guest() || $sigId === null)
                   ? false
                   : (Auth::user()->canEditSig($sigId));

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

