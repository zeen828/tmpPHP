<?php

namespace App\Repositories\Jwt;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Jwt\AuthRepository;
use App\Entities\Jwt\Auth;
use App\Validators\Jwt\AuthValidator;

/**
 * Class AuthRepositoryEloquent.
 *
 * @package namespace App\Repositories\Jwt;
 */
class AuthRepositoryEloquent extends BaseRepository implements AuthRepository
{
    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\\Presenters\\Jwt\\AuthPresenter";
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Auth::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        // Return empty is to close the validator about create and update on the repository.
        return AuthValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
