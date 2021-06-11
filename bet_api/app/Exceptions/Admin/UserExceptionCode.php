<?php

namespace App\Exceptions\Admin;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class UserExceptionCode.
 *
 * @package App\Exceptions\Admin
 */
class UserExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const ACCOUNT_EXISTS = 1;

    const INOPERABLE_USER = 2;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::ACCOUNT_EXISTS => 'Account has been registered by other admins.',
      self::INOPERABLE_USER => 'Operation prohibited by invalid user object.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
        return "App\\Exceptions\\Admin\\UserExceptionCode";
    }
}
