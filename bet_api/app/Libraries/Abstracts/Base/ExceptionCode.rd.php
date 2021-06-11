<?php
/*
 >> Information

    Title		: Exception Code
    Revision	: 1.0.0
    Notes		:

    Revision History:
    When			Create		When		Edit		Description
    ---------------------------------------------------------------------------
    10-22-2018		Poen		02-07-2020	Poen		Code maintenance.
    ---------------------------------------------------------------------------

 >> About

    file > (app/Libraries/Abstracts/Base/ExceptionCode.php) :
    The exception code throws the message integrator base class.

    file > (config/exception.php) :
    The exception converter to display error code config.

 >> Artisan Commands

    Create a object file.
    $php artisan make:ex-code <name>

    Cancel creating converter language file.
    $php artisan make:ex-code --noconverter <name>

 >> Learn

    Step 1 :
    Create ExceptionCode object class.

    $php artisan make:ex-code Jwt\Auth

    Example : App\Exceptions\Jwt\AuthExceptionCode object class

    File : app/Exceptions/Jwt/AuthExceptionCode.php

    Step 2 :
    Edit exception code error.

    File : config / exception.php

    Example :
    --------------------------------------------------------------------------
    return [
        App\Exceptions\Jwt\AuthExceptionCode::class => [
            0 => 0,
        ],
        //:end-generating:
    ];

    Step 3 :
    Edit language file.

    File : resources/lang/ language dir /exception/App/Exceptions/Jwt/AuthExceptionCode/converter.php

    Example :
    --------------------------------------------------------------------------
    use App\Exceptions\Jwt\AuthExceptionCode as ExceptionCode;

    return [
        'default' => [
            'code' => (string) ExceptionCode::NORMAL,
            'status' => 500,
            'message' => 'Something error happens.'
        ],
        'customize' => [
            500 => [
                ExceptionCode::NORMAL => [
                    'code' => (string) ExceptionCode::NORMAL,
                    'status' => 500,
                    'message' => 'Something error happens.'
                ],
            ]
        ]
    ];

    Step 4 :
    Call throw exception.

    Example :
    --------------------------------------------------------------------------
    use App\Exceptions\Jwt\AuthExceptionCode as ExceptionCode;

    throw new ExceptionCode(ExceptionCode::AUTH_FAIL);

    Step 5 :
    Call throw exception and replace converter message tags.

    Example :
    --------------------------------------------------------------------------
    use App\Exceptions\Jwt\AuthExceptionCode as ExceptionCode;

    throw new ExceptionCode(ExceptionCode::AUTH_FAIL, ['%user%' => '1294583', '%type%' => 'admin']);

    Step 6 :
    Call throw exception and replace source message tags.

    Example :
    --------------------------------------------------------------------------
    use App\Exceptions\Jwt\AuthExceptionCode as ExceptionCode;

    throw new ExceptionCode(ExceptionCode::AUTH_FAIL, [], ['%user%' => '1294583', '%type%' => 'admin']);

    Step 7 :
    Call throw exception and custom description.

    Example :
    --------------------------------------------------------------------------
    use App\Exceptions\Jwt\AuthExceptionCode as ExceptionCode;
    use Illuminate\Support\MessageBag;

    $description = app(MessageBag::class);
    $description->add('about', 'This a error description.');

    throw new ExceptionCode(ExceptionCode::AUTH_FAIL, [], [], $description);

 */
