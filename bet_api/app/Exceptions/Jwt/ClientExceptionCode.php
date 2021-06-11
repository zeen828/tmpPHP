<?php

namespace App\Exceptions\Jwt;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class ClientExceptionCode.
 *
 * @package App\Exceptions\Jwt
 */
class ClientExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;
    
    const BAN_NUMBER_DISABLED = 1;

    const SERVICE_EXISTS = 2;

    const INOPERABLE_CLIENT = 3;
    
    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::BAN_NUMBER_DISABLED => 'Ban number disabled.',
      self::SERVICE_EXISTS => 'Service client id already exists.',
      self::INOPERABLE_CLIENT => 'Operation prohibited by invalid client service object.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
        return "App\\Exceptions\\Jwt\\ClientExceptionCode";
    }
}
