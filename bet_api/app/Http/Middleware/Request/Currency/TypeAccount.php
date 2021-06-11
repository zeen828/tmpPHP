<?php

namespace App\Http\Middleware\Request\Currency;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TypeAccount
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
        $tid = $request->route()->parameter('account');
        if (isset($type['class'], $tid)) {
            /* Check the user id format */
            $id = app($type['class'])->asPrimaryId($tid);
            if (! isset($id)) {
                throw new ModelNotFoundException('Query Currency Account: No query results for users: Unknown user account \'' . $tid . '\'.');
            } else {
                /* Set real id */
                $request->route()->setParameter('account', $id);
            }
        }

        return $next($request);
    }
}
