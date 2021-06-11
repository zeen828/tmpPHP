<?php

namespace App\Exceptions\LotteryGames;

use App\Libraries\Abstracts\Base\ExceptionCode as ExceptionCodeBase;

/**
 * Class GameBetExceptionCode.
 *
 * @package App\Exceptions\LotteryGames
 */
class GameBetExceptionCode extends ExceptionCodeBase
{
    // Custom exception constant code
    const NORMAL = 0;

    const NOT_EXIST = 1;

    const NOT_ENOUGH_POINT = 2;

    const WRONG_BET_VALUE = 3;

    const CANNOT_BET_TODAY = 4;

    // Custom exception debug message
    const DEBUG_MESSAGE = [
      self::NORMAL => 'Please check for this exception.',
      self::NOT_EXIST => 'Game lottery bet does not exist.',
      self::NOT_ENOUGH_POINT => 'Not enough points required to play the game.',
      self::WRONG_BET_VALUE => 'The betting information is incorrect.',
      self::CANNOT_BET_TODAY => 'Cannot place bets today.',
    ];

    /**
     * Specify exception converter by class name
     *
     * @return string
     */
    public function getExceptionConverter(): string
    {
       return "App\\Exceptions\\LotteryGames\\GameBetExceptionCode";
    }
}
