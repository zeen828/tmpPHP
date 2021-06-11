<?php

namespace App\Exceptions\Business;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class ServiceExceptionCode.
 *
 * @package App\Exceptions\Business
 */
class ServiceExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const UNAVAILABLE_SERVICE = 1;

    const UNAUTHORIZED_IP = 2;

    const AUTH_LINK_CREATE_FAIL = 3;
    
    const USER_TYPE_NOT_SUPPORT = 4;

    const INVALID_USER = 5;

    const INVITE_LINK_CREATE_FAIL = 6;

    const INVITER_TYPE_NOT_SUPPORT = 7;

    const INVALID_INVITER = 8;

    const UNAVAILABLE_INVITE = 9;

    const NON_PERMITTED_INVITER_OBJECT = 10;

    const INVALID_SIGNATURE = 11;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::UNAVAILABLE_SERVICE => 'The service has not been activated yet.',
      self::UNAUTHORIZED_IP => 'Unauthorized source IP : \'%ip%\' .',
      self::AUTH_LINK_CREATE_FAIL => 'The login link signature authorization failed.',
      self::USER_TYPE_NOT_SUPPORT => 'The user type is not supported.',
      self::INVALID_USER => 'Invalid user object.',
      self::INVITE_LINK_CREATE_FAIL => 'The invitation link signature authorization failed.',
      self::INVITER_TYPE_NOT_SUPPORT => 'The inviter type is not supported.',
      self::INVALID_INVITER => 'Invalid inviter object.',
      self::UNAVAILABLE_INVITE => 'Unavailable invitation.',
      self::NON_PERMITTED_INVITER_OBJECT => 'Non-permitted inviter object.',
      self::INVALID_SIGNATURE => 'Invalid signature authorization code.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
       return "App\\Exceptions\\Business\\ServiceExceptionCode";
    }
}
