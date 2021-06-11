<?php

namespace App\Validators\LotteryGames;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class GameRuleValidator.
 *
 * @package namespace App\Validators\LotteryGames;
 */
class GameRuleValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'game_id' => 'required|integer',
            'type_id' => 'required|integer',
            'name' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
