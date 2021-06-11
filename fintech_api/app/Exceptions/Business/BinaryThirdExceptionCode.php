<?php

namespace App\Exceptions\Business;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class BinaryThirdExceptionCode.
 *
 * @package App\Exceptions\Business
 */
class BinaryThirdExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
       return "App\\Exceptions\\Business\\BinaryThirdExceptionCode";
    }
}
