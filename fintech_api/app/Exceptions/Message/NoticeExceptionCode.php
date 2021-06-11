<?php

namespace App\Exceptions\Message;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class NoticeExceptionCode.
 *
 * @package App\Exceptions\Message
 */
class NoticeExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;
    
    const NO_READ_NOTIFICATIONS = 1;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::NO_READ_NOTIFICATIONS => 'No notifications have been read.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
        return "App\\Exceptions\\Message\\NoticeExceptionCode";
    }
}
