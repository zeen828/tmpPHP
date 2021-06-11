<?php

namespace App\Exceptions\Member;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class UserExceptionCode.
 *
 * @package App\Exceptions\Member
 */
class UserExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const USER_AUTH_FAIL = 1;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::USER_AUTH_FAIL => 'Verify the user credentials is incorrect.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
       return "App\\Exceptions\\Member\\UserExceptionCode";
    }
}
