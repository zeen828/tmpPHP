<?php

namespace App\Exceptions\Admin;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class AuthExceptionCode.
 *
 * @package App\Exceptions\Admin
 */
class AuthExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const PASSWORD_CONFIRM_FAIL = 1;

    const SERVICE_REJECTED = 2;

    const UNSPECIFIED_DATA_COLUMN = 3;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::PASSWORD_CONFIRM_FAIL => 'Password confirmation is incorrect.',
      self::SERVICE_REJECTED => 'User service usage rights have been disabled.',
      self::UNSPECIFIED_DATA_COLUMN => 'Unspecified data column.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
        return "App\\Exceptions\\Admin\\AuthExceptionCode";
    }
}
