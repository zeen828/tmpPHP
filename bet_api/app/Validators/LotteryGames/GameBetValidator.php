<?php

namespace App\Validators\LotteryGames;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class GameBetValidator.
 *
 * @package namespace App\Validators\LotteryGames;
 */
class GameBetValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'required|integer',
            'game_id' => 'required|integer',
            'draw_id' => 'required|integer',
            'rule_id' => 'required|integer',
            'value' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
