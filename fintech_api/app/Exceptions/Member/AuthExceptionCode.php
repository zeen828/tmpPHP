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

    const PIN_CONFIRM_FAIL = 1;

    const SERVICE_REJECTED = 2;

    const TERMS_NOT_AGREED = 3;

    const TERMS_HAVE_AGREED = 4;

    const PIN_FAIL = 5;

    const PASSWORD_CONFIRM_FAIL = 6;

    const UNSPECIFIED_DATA_COLUMN = 7;

    const ACCOUNT_EXISTS = 8;

    const PHONE_VERIFYCODE_FAIL = 9;

    const PHONE_VERIFYCODE_SEND_FAIL = 10;

    const PHONE_EXISTS = 11;

    const EMAIL_EXISTS = 12;

    const NICKNAME_EXISTS = 13;

    const PIN_CODE_UNDEFINED = 14;

    const BANK_ACCOUNT_UNDEFINED = 15;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::PIN_CONFIRM_FAIL => 'Pin code confirmation is incorrect.',
      self::SERVICE_REJECTED => 'User service usage rights have been disabled.',
      self::TERMS_NOT_AGREED => 'User has not yet agreed to the terms of service.',
      self::TERMS_HAVE_AGREED => 'User has agreed to the terms of service.',
      self::PIN_FAIL => 'Pin code is incorrect.',
      self::PASSWORD_CONFIRM_FAIL => 'Password confirmation is incorrect.',
      self::UNSPECIFIED_DATA_COLUMN => 'Unspecified data column.',
      self::ACCOUNT_EXISTS => 'Account has been registered by other member.',
      self::PHONE_VERIFYCODE_FAIL => 'Phone verifycode error.',
      self::PHONE_VERIFYCODE_SEND_FAIL => 'Phone verifycode failed to send.',
      self::PHONE_EXISTS => 'Phone has been registered by other member.',
      self::EMAIL_EXISTS => 'E-mail has been registered by other member.',
      self::NICKNAME_EXISTS => 'Nickname has been registered by other member.',
      self::PIN_CODE_UNDEFINED => 'Pin code information is not configured.',
      self::BANK_ACCOUNT_UNDEFINED => 'Bank account information is not configured.',
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
