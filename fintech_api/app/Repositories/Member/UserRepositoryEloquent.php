<?php

namespace App\Repositories\Member;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Member\UserRepository;
use App\Entities\Member\User;
use App\Validators\Member\UserValidator;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Member;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\\Presenters\\Member\\UserPresenter";
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        // Return empty is to close the validator about create and update on the repository.
        return UserValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get a list of data for existing members.
     *
     * @param int $perPage
     *
     * @return array
     */
    public function index(int $perPage = 15): array
    {
        /* Criteria Index */
        $this->pushCriteria(app('App\Criteria\Member\User\IndexCriteria'));

        $result = $this->paginate($perPage);
        if (isset($result['meta']['pagination']['links'])) {
            unset($result['meta']['pagination']['links']);
        }
        return $result;
    }
    
    /**
     * Get data centered on existing member's primary key id.
     *
     * @param int $id
     *
     * @return array
     * @throws \Exception
     */
    public function focusMember(int $id): array
    {
        $result = $this->find($id);

        return $result['data'];
    }

    /**
     * Disable focus member.
     *
     * @param int $id
     *
     * @return void
     * @throws \Exception
     */
    public function focusDisable(int $id)
    {
        $this->update([
            'status' => 0
        ], $id);
    }

    /**
     * Enable focus member.
     *
     * @param int $id
     *
     * @return void
     * @throws \Exception
     */
    public function focusEnable(int $id)
    {
        $this->update([
            'status' => 1
        ], $id);
    }
}
