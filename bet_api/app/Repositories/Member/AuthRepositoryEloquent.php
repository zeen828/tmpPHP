<?php

namespace App\Repositories\Member;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Member\AuthRepository;
use App\Entities\Member\Auth;
use App\Validators\Member\AuthValidator;
use App\Exceptions\Member\AuthExceptionCode as ExceptionCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
use SystemParameter;
use Str;
use StorageCode;
use TokenAuth;

/**
 * Class AuthRepositoryEloquent.
 *
 * @package namespace App\Repositories\Member;
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
        return "App\\Presenters\\Member\\AuthPresenter";
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

    /**
     * Change a new extract password.
     *
     * @param Auth $user
     * @param string $password
     *
     * @return void
     * @throws \Exception
     */
    public function changeExtractPassword(Auth $user, string $password)
    {
        if (!$user->exists) {
            throw new ModelNotFoundException('No query results for object model [' . get_class($user) . '] ');
        }

        $user->update([
            'password_extract' => bcrypt($password)
        ]);
    }
}
