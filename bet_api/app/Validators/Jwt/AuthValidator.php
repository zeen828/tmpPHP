<?php

namespace App\Validators\Jwt;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

/**
 * Class AuthValidator.
 *
 * @package namespace App\Validators\Jwt;
 */
class AuthValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => []
    ];
}
