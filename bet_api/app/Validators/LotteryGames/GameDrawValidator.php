<?php

namespace App\Validators\LotteryGames;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class GameDrawValidator.
 *
 * @package namespace App\Validators\LotteryGames;
 */
class GameDrawValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'game_id' => 'required|integer',
            'period' => 'required',
            'draw_at' => 'required',
            'ready_at' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
