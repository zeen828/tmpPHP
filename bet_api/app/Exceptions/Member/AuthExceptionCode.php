<?php

namespace App\Exceptions\Member;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class AuthExceptionCode.
 *
 * @package App\Exceptions\Member
 */
class AuthExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const MEMBER_USER_FREEZE = 1;

    const MEMBER_USER_REJECTED = 2;

    const SIGNATURE_CREATE_FAIL = 3;

    const USER_AUTH_FAIL = 4;

    const PASSWORD_CONFIRM_FAIL = 5;

    const DOCKING_CLIENT_FAIL = 6;

    const DOCKING_USER_FAIL = 7;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::MEMBER_USER_FREEZE => 'The member user has been freeze.',
      self::MEMBER_USER_REJECTED => 'The member user has been deactivated.',
      self::SIGNATURE_CREATE_FAIL => 'The signature authorization failed.',
      self::USER_AUTH_FAIL => 'Verify the user credentials is incorrect.',
      self::PASSWORD_CONFIRM_FAIL => 'Password confirmation is incorrect.',
      self::DOCKING_CLIENT_FAIL => 'Docking server client an error.',
      self::DOCKING_USER_FAIL => 'Docking server user an error.',
    ];
    
    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
        return "App\\Exceptions\\Member\\AuthExceptionCode";
    }
}
