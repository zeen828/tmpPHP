<?php

namespace App\Http\Middleware\Accept;

use App\Exceptions\System\AcceptExceptionCode as ExceptionCode;
use Closure;

class ResponseType
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /* Get response limit type */
        if ($request->is(config('app.accept_response_json', ['api/*']))) {
            $types = [
                'application/json'
            ];
        } else {
            $types = [
                'text/html'
            ];
        }
        /* Accept response type */
        if (! $request->accepts($types)) {
            throw new ExceptionCode(ExceptionCode::UNACCEPTABLE_RESPONSE_TYPE);
        }
        
        return $next($request);
    }
}