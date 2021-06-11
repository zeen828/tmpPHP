<?php

namespace App\Exceptions\Message;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class BulletinExceptionCode.
 *
 * @package App\Exceptions\Message
 */
class BulletinExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;
    
    const NON_ANNOUNCEABLE_USER_TYPE = 1;

    const CREATE_FAIL = 2;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::NON_ANNOUNCEABLE_USER_TYPE => 'Non-announceable user types.',
      self::CREATE_FAIL => 'Failed to build notification.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
       return "App\\Exceptions\\Message\\BulletinExceptionCode";
    }
}
