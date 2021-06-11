<?php
return [

    /*
     * |--------------------------------------------------------------------------
     * | Exception Converter Thrown Code Swap Display Error Code
     * |--------------------------------------------------------------------------
     * |
     * | Set a list of exception classes error code.
     * | Exception Class => [
     * |    Exception thrown error code => Exception display error code,
     * | ],
     */

    Illuminate\Auth\Access\AuthorizationException::class => [
        0 => 10010000,
    ],
    Illuminate\Auth\AuthenticationException::class => [
        0 => 10020000,
    ],
    Illuminate\Contracts\Encryption\DecryptException::class => [
        0 => 10030000,
    ],
    Illuminate\Database\Eloquent\ModelNotFoundException::class => [
        0 => 10040000,
    ],
    Illuminate\Database\QueryException::class => [
        0 => 10050000,
    ],
    Illuminate\Validation\ValidationException::class => [
        0 => 10060000,
    ],
    Libphonenumber\NumberParseException::class => [
        0 => 10070000,
        1 => 10070001,
        2 => 10070002,
        3 => 10070003,
        4 => 10070004,
    ],
    Propaganistas\LaravelPhone\Exceptions\CountryCodeException::class => [
        0 => 10070005,
    ],
    Propaganistas\LaravelPhone\Exceptions\InvalidParameterException::class => [
        0 => 10070006,
    ],
    Propaganistas\LaravelPhone\Exceptions\NumberFormatException::class => [
        0 => 10070007,
    ],
    Propaganistas\LaravelPhone\Exceptions\NumberParseException::class => [
        0 => 10070008,
    ],
    Prettus\Validator\Exceptions\ValidatorException::class => [
        0 => 10080000,
    ],
    Symfony\Component\Debug\Exception\FatalThrowableErrorException::class => [
        0 => 10090000,
    ],
    Symfony\Component\HttpKernel\Exception\HttpException::class => [
        0 => 10100000,
    ],
    Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class => [
        0 => 10110000,
    ],
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => [
        0 => 10120000,
    ],
    Tymon\JWTAuth\Exceptions\InvalidClaimException::class => [
        0 => 10130000,
    ],
    Tymon\JWTAuth\Exceptions\JWTException::class => [
        0 => 10140000,
    ],
    Tymon\JWTAuth\Exceptions\PayloadException::class => [
        0 => 10150000,
    ],
    Tymon\JWTAuth\Exceptions\TokenBlacklistedException::class => [
        0 => 10160000,
    ],
    Tymon\JWTAuth\Exceptions\TokenExpiredException::class => [
        0 => 10170000,
    ],
    Tymon\JWTAuth\Exceptions\TokenInvalidException::class => [
        0 => 10180000,
    ],
    Tymon\JWTAuth\Exceptions\UserNotDefinedException::class => [
        0 => 10190000,
    ],
    App\Exceptions\System\AcceptExceptionCode::class => [
        0 => 20010000,
        1 => 20010001,
        2 => 20010002,
        3 => 20010003,
        4 => 20010004,
    ],
    App\Exceptions\Jwt\AuthExceptionCode::class => [
        0 => 20020000,
        1 => 20020001,
        2 => 20020002,
        3 => 20020003,
        4 => 20020004,
        5 => 20020005,
        6 => 20020006,
        7 => 20020007,
        8 => 20020008,
        9 => 20020009,
        10 => 20020010,
    ],
    App\Exceptions\Jwt\ClientExceptionCode::class => [
        0 => 30010000,
        1 => 30010001,
        2 => 30010002,
        3 => 30010003,
    ],
    App\Exceptions\System\DataActivityExceptionCode::class => [
        0 => 30020000,
    ],
    App\Exceptions\System\LanguageExceptionCode::class => [
        0 => 30030000,
    ],
    App\Exceptions\System\ParameterExceptionCode::class => [
        0 => 30040000,
        1 => 30040001,
        2 => 30040002,
    ],
    App\Exceptions\Feature\ProviderExceptionCode::class => [
        0 => 30050000,
        1 => 30050001,
        2 => 30050002,
    ],
    App\Exceptions\System\InterfaceExceptionCode::class => [
        0 => 30060000,
    ],
    App\Exceptions\System\AuthorityExceptionCode::class => [
        0 => 30070000,
        1 => 30070001,
        2 => 30070002,
        3 => 30070003,
        4 => 30070004,
        5 => 30070005,
    ],
    App\Exceptions\Message\NoticeExceptionCode::class => [
        0 => 30080000,
        1 => 30080001,
    ],
    App\Exceptions\System\AuthoritySnapshotExceptionCode::class => [
        0 => 30090000,
        1 => 30090001,
        2 => 30090002,
    ],
    App\Exceptions\Sms\OperateExceptionCode::class => [
        0 => 30100000,
        1 => 30100001,
        2 => 30100002,
        3 => 30100003,
        4 => 30100004,
        5 => 30100005,
        6 => 30100006,
    ],
    App\Exceptions\Message\BulletinExceptionCode::class => [
        0 => 30110000,
        1 => 30110001,
        2 => 30110002,
    ],
    App\Exceptions\System\CellExceptionCode::class => [
        0 => 30120000,
        1 => 30120001,
        2 => 30120002,
        3 => 30120003,
    ],
    App\Exceptions\Admin\AuthExceptionCode::class => [
        0 => 40010000,
        1 => 40010001,
        2 => 40010002,
        3 => 40010003,
    ],
    App\Exceptions\Admin\UserExceptionCode::class => [
        0 => 40020000,
        1 => 40020001,
        2 => 40020002,
    ],
    App\Exceptions\Member\AuthExceptionCode::class => [
        0 => 40030000,
        1 => 40030001,
        2 => 40030002,
        3 => 40030003,
        4 => 40030004,
        5 => 40030005,
        6 => 40030006,
        7 => 40030007,
        8 => 40030008,
        9 => 40030009,
        10 => 40030010,
        11 => 40030011,
        12 => 40030012,
        13 => 40030013,
        14 => 40030014,
        15 => 40030015,
    ],
    App\Exceptions\Member\UserExceptionCode::class => [
        0 => 40040000,
    ],
    App\Exceptions\Trade\OperateExceptionCode::class => [
        0 => 40050000,
        1 => 40050001,
        2 => 40050002,
        3 => 40050003,
        4 => 40050004,
        5 => 40050005,
        6 => 40050006,
        7 => 40050007,
        8 => 40050008,
        9 => 40050009,
        10 => 40050010,
        11 => 40050011,
        16 => 40050016,
        17 => 40050017,
        18 => 40050018,
        19 => 40050019,
        20 => 40050020,
        21 => 40050021,
    ],
    App\Exceptions\Receipt\OperateExceptionCode::class => [
        0 => 40060000,
        1 => 40060001,
        2 => 40060002,
        3 => 40060003,
        4 => 40060004,
        5 => 40060005,
        6 => 40060006,
    ],
    App\Exceptions\Business\ServiceExceptionCode::class => [
        0 => 40070000,
        1 => 40070001,
        2 => 40070002,
        3 => 40070003,
        4 => 40070004,
        5 => 40070005,
        6 => 40070006,
        7 => 40070007,
        8 => 40070008,
        9 => 40070009,
        10 => 40070010,
        11 => 40070011,
    ],
    App\Exceptions\Exchange\ServiceExceptionCode::class => [
        0 => 40080000,
        1 => 40080001,
        2 => 40080002,
        3 => 40080003,
        4 => 40080004,
        5 => 40080005,
        6 => 40080006,
        7 => 40080007,
        8 => 40080008,
    ],
    App\Exceptions\Business\BetThirdExceptionCode::class => [
        0 => 50010000,
    ],
    App\Exceptions\Business\BinaryThirdExceptionCode::class => [
        0 => 50020000,
    ],
    App\Exceptions\Exchange\PaydayThirdExceptionCode::class => [
        0 => 50030000,
        1 => 50030001,
    ],
    //:end-generating:
];
