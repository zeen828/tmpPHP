<?php

namespace App\Exceptions\Exchange;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class PaydayThirdExceptionCode.
 *
 * @package App\Exceptions\Exchange
 */
class PaydayThirdExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const USER_TYPE_NOT_SUPPORT = 1;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::USER_TYPE_NOT_SUPPORT => 'The user type is not supported.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
       return "App\\Exceptions\\Exchange\\PaydayThirdExceptionCode";
    }
}
