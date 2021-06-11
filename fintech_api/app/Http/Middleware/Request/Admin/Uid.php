<?php

namespace App\Http\Middleware\Request\Admin;

use Closure;
use App\Entities\Admin\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Uid
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
        /* Check the user id format */
        $tid = $request->route()->parameter('uid');
        if (isset($tid)) {
            $id = app(Auth::class)->asPrimaryId($tid);
            if (! isset($id)) {
                throw new ModelNotFoundException('Query Admin: No query results for users: Unknown user uid \'' . $tid . '\'.');
            } else {
                /* Set real id */
                $request->route()->setParameter('uid', $id);
            }
        }

        return $next($request);
    }
}
