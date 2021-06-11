<?php

namespace App\Exceptions\Trade;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class OperateExceptionCode.
 *
 * @package App\Exceptions\Trade
 */
class OperateExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const ACCOUNTABLE_UNDEFINED = 1;

    const SOURCEABLE_UNDEFINED = 2;

    const INVALID_AMOUNT = 3;

    const INSUFFICIENT_AMOUNT = 4;

    const TRADE_UNSTARTED = 5;

    const NON_PERMITTED_TRADE_OBJECT = 6;

    const SREVICE_SUSPENDED = 7;

    const UNKNOWN_OBJECT_FROM_SOURCEABLE = 8;

    const UNKNOWN_OBJECT_FROM_ACCOUNTABLE = 9;

    const ACCOUNT_FROZEN = 10;

    const UNKNOWN_ORDER_FROM_PARENT = 11;

    const UNAUTHORIZED_OPERATION = 16;

    const SIGNATURE_CREATE_FAIL = 17;

    const UNUSUALLY_FROZEN_ACCOUNT = 18;

    const INVALID_ACCOUNT_ID = 19;

    const SOURCE_OPERATION_DISABLED = 20;

    const INVALID_BALANCE = 21;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
        self::NORMAL => 'Please check for this exception.',
        self::ACCOUNTABLE_UNDEFINED => 'Undefined accountable model audience.',
        self::SOURCEABLE_UNDEFINED => 'Undefined sourceable model audience.',
        self::INVALID_AMOUNT => 'Invalid trading amount.',
        self::INSUFFICIENT_AMOUNT => 'Insufficient amount.',
        self::TRADE_UNSTARTED => 'Submit failed and the transaction was not started.',
        self::NON_PERMITTED_TRADE_OBJECT => 'Non-permitted trading object.',
        self::SREVICE_SUSPENDED => 'Trading services are currently suspended.',
        self::UNKNOWN_OBJECT_FROM_SOURCEABLE => 'Unknown object from the sourceable model.',
        self::UNKNOWN_OBJECT_FROM_ACCOUNTABLE => 'Unknown object from the accountable model.',
        self::ACCOUNT_FROZEN => 'The trading account service has been frozen.',
        self::UNKNOWN_ORDER_FROM_PARENT => 'The parent order is an unknown order.',
        self::UNAUTHORIZED_OPERATION => 'Unauthorized operation, transaction source restriction.',
        self::SIGNATURE_CREATE_FAIL => 'The signature authorization failed.',
        self::UNUSUALLY_FROZEN_ACCOUNT => 'Due to illegal data, the account was abnormally frozen.',
        self::INVALID_ACCOUNT_ID => 'Invalid account identification.',
        self::SOURCE_OPERATION_DISABLED => 'Source object authorization operation has been disabled.',
        self::INVALID_BALANCE => 'Invalid trading amount balance.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
        return "App\\Exceptions\\Trade\\OperateExceptionCode";
    }
}
