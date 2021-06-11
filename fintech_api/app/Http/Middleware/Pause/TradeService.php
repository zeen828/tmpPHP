<?php

namespace App\Http\Middleware\Pause;

use Closure;
use App\Exceptions\Trade\OperateExceptionCode as ExceptionCode;
use Carbon;
use SystemParameter;

class TradeService
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
        if (SystemParameter::getValue('trade_service_start_at') >= Carbon::now()->toDateTimeString()) {
            throw new ExceptionCode(ExceptionCode::SREVICE_SUSPENDED);
        }

        return $next($request);
    }
}
