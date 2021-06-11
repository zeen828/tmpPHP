<?php

namespace App\Exceptions\LotteryGames;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class GameDrawExceptionCode.
 *
 * @package App\Exceptions\LotteryGames
 */
class GameDrawExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const NOT_EXIST = 1;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::NOT_EXIST => 'Game lottery draw does not exist.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
       return "App\\Exceptions\\LotteryGames\\GameDrawExceptionCode";
    }
}
