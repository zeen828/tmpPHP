<?php

namespace App\Repositories\Admin;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Admin\AuthRepository;
use App\Entities\Admin\Auth;
use App\Validators\Admin\AuthValidator;
use App\Exceptions\Admin\AuthExceptionCode as ExceptionCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class AuthRepositoryEloquent.
 *
 * @package namespace App\Repositories\Admin;
 */
class AuthRepositoryEloquent extends BaseRepository implements AuthRepository
{
    /**
     * The profile columns list.
     *
     * @var array
     */
    private $columns = [
        'email',
        'name'
    ];

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\\Presenters\\Admin\\AuthPresenter";
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
    * Change a new password.
    *
    * @param Auth $user
    * @param string $password
    *
    * @return void
    * @throws \Exception
    */
    public function changePassword(Auth $user, string $password)
    {
        if (!$user->exists) {
            throw new ModelNotFoundException('No query results for object model [' . get_class($user) . '] ');
        }

        $user->update([
            'password' => $password
        ]);
    }

    /**
    * Edit user profile.
    *
    * @param Auth $user
    * @param array $profile
    *
    * @return void
    * @throws \Exception
    */
    public function editProfile(Auth $user, array $profile)
    {
        if (!$user->exists) {
            throw new ModelNotFoundException('No query results for object model [' . get_class($user) . '] ');
        }
        
        $profile = array_intersect_key($profile, array_flip($this->columns));

        $profile = collect($profile)->map(function ($item) {
            return $item;
        })->reject(function ($item) {
            return empty($item);
        })->all();

        if (count($profile) > 0) {
            $user->update($profile);
        } else {
            throw new ExceptionCode(ExceptionCode::UNSPECIFIED_DATA_COLUMN);
        }
    }
}
