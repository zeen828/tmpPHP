<?php

namespace App\Validators\LotteryGames;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class GameSettingValidator.
 *
 * @package namespace App\Validators\LotteryGames;
 */
class GameSettingValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
