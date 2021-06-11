<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
        \Prettus\Validator\Exceptions\ValidatorException::class,
        \Tymon\JWTAuth\Exceptions\JWTException::class,
        \App\Libraries\Abstracts\Base\ExceptionCode::class,
        \Libphonenumber\NumberParseException::class,
        \Propaganistas\LaravelPhone\Exceptions\CountryCodeException::class,
        \Propaganistas\LaravelPhone\Exceptions\InvalidParameterException::class,
        \Propaganistas\LaravelPhone\Exceptions\NumberFormatException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation'
    ];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        return response()->error($exception);
    }
}
