<?php

namespace App\Exceptions\Exchange;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class ServiceExceptionCode.
 *
 * @package App\Exceptions\Exchange
 */
class ServiceExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const UNAVAILABLE_SERVICE = 1;

    const UNAUTHORIZED_IP = 2;

    const BILLING_TYPE_UNDEFINED = 3;

    const BILLING_LINK_CREATE_FAIL = 4;

    const BILLING_AUTH_FAIL = 5;

    const BILLING_TO_PAYMENT_FAIL = 6;

    const INVALID_ORDER_STATUS = 7;

    const ORDER_TYPE_WRONG = 8;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::UNAVAILABLE_SERVICE => 'The service has not been activated yet.',
      self::UNAUTHORIZED_IP => 'Unauthorized source IP : \'%ip%\' .',
      self::BILLING_TYPE_UNDEFINED => 'Undefined billing type.',
      self::BILLING_LINK_CREATE_FAIL => 'The billing link signature authorization of failed.',
      self::BILLING_AUTH_FAIL => 'Verify the bill voucher is incorrect.',
      self::BILLING_TO_PAYMENT_FAIL => 'Payment failed : %message%',
      self::INVALID_ORDER_STATUS => 'Invalid order the status has been changed.',
      self::ORDER_TYPE_WRONG => 'Order type is wrong.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
       return "App\\Exceptions\\Exchange\\ServiceExceptionCode";
    }
}
