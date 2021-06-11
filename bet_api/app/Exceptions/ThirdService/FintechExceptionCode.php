<?php

namespace App\Exceptions\ThirdService;

// use Exception;
use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

// class FintechExceptionCode extends Exception
class FintechExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const USER_AUTH_FAIL = 1;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::USER_AUTH_FAIL => 'User login.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
       return "App\\Exceptions\\ThirdService\\FintechExceptionCode";
    }
}
