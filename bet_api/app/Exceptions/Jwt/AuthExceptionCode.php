<?php

namespace App\Exceptions\Jwt;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class AuthExceptionCode.
 *
 * @package App\Exceptions\Jwt
 */
class AuthExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const CLIENT_AUTH_FAIL = 1;

    const AUTH_FAIL = 2;

    const TOKEN_CREATE_FAIL = 3;

    const CLIENT_NON_EXIST = 4;

    const SERVICE_REJECTED = 5;

    const NO_PERMISSION = 6;

    const USER_AUTH_FAIL = 7;

    const TOKEN_OTHER_GUARD_AUTHORIZED = 8;

    const USER_NON_EXIST = 9;

    const SIGNATURE_CREATE_FAIL = 10;

    const DOCKING_CLIENT_FAIL = 11;

    const DOCKING_USER_FAIL = 12;

    const DOCKING_CLIENT_READ_FAIL = 13;

    const DOCKING_USER_READ_FAIL = 14;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
        self::NORMAL => 'Please check for this exception.',
        self::CLIENT_AUTH_FAIL => 'Verify the client credentials is incorrect.',
        self::AUTH_FAIL => 'Verify the credentials is incorrect.',
        self::TOKEN_CREATE_FAIL => 'The token authorization failed.',
        self::CLIENT_NON_EXIST => 'The client does not exist.',
        self::SERVICE_REJECTED => 'The client service has been deactivated.',
        self::NO_PERMISSION => 'The client service has been banned.',
        self::USER_AUTH_FAIL => 'Verify the user credentials is incorrect.',
        self::TOKEN_OTHER_GUARD_AUTHORIZED => 'The token has been authorized for other identity guards.',
        self::USER_NON_EXIST => 'The user does not exist.',
        self::SIGNATURE_CREATE_FAIL => 'The signature authorization failed.',
        self::DOCKING_CLIENT_FAIL => 'Docking clinet auth fail.',
        self::DOCKING_USER_FAIL => 'Docking user auth fail.',
        self::DOCKING_CLIENT_READ_FAIL => 'Docking client read fail.',
        self::DOCKING_USER_READ_FAIL => 'Docking user read fail.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
        return "App\\Exceptions\\Jwt\\AuthExceptionCode";
    }
}
