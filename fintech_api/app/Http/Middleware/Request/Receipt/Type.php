<?php

namespace App\Http\Middleware\Request\Receipt;

use Closure;
use App\Entities\Receipt\Operate;

class Type
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
        $type = $request->route()->parameter('type');
        if (isset($type)) {
            /* Check type */
            $type = app(Operate::class)->formTypes(['type'], $type);
            /* Set type info */
            $request->route()->setParameter('type', $type['type']);
        }

        return $next($request);
    }
}
