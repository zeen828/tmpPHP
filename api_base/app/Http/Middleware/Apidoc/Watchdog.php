<?php

namespace App\Http\Middleware\Apidoc;

use Closure;

class Watchdog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $named = $request->route()->getName();
        if (($named === 'apidoc.json' && ! config('apidoc.postman.enabled', false)) || (($named === 'apidoc' || $named === 'apidoc.json') && ! in_array($request->ip(), config('apidoc.laravel.watchdog_whitelisted', [])))) {
            abort(404, 'Resource not found.');
        }
        return $next($request);
    }
}