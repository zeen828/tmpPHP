<?php

namespace App\Exceptions\Receipt;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class OperateExceptionCode.
 *
 * @package App\Exceptions\Receipt
 */
class OperateExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const FORMDEFINE_UNDEFINED = 1;

    const SOURCEABLE_UNDEFINED = 2;

    const NON_PERMITTED_FORM_OBJECT = 3;

    const UNKNOWN_OBJECT_FROM_SOURCEABLE = 4;

    const UNKNOWN_ORDER_FROM_PARENT = 5;

    const SOURCE_OPERATION_DISABLED = 6;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
        self::NORMAL => 'Please check for this exception.',
        self::FORMDEFINE_UNDEFINED => 'Undefined form type.',
        self::SOURCEABLE_UNDEFINED => 'Undefined sourceable model audience.',
        self::NON_PERMITTED_FORM_OBJECT => 'Non-permitted form object.',
        self::UNKNOWN_OBJECT_FROM_SOURCEABLE => 'Unknown object from the sourceable model.',
        self::UNKNOWN_ORDER_FROM_PARENT => 'The parent order is an unknown order.',
        self::SOURCE_OPERATION_DISABLED => 'Source object authorization operation has been disabled.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
       return "App\\Exceptions\\Receipt\\OperateExceptionCode";
    }
}
