<?php

namespace App\Repositories\Admin;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Admin\UserRepository;
use App\Entities\Admin\User;
use App\Validators\Admin\UserValidator;
use App\Exceptions\Admin\UserExceptionCode as ExceptionCode;
use DB;
use App\Entities\Admin\Auth;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Admin;
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
        return "App\\Presenters\\Admin\\UserPresenter";
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
    * Sign up for a new admin account.
    *
    * @param string $account
    * @param string $password
    *
    * @return object
    * @throws \Exception
    */
    public function register(string $account, string $password): object
    {
        try {
            DB::beginTransaction();
            
            $result = Auth::create([
                'account' => $account,
                'password' => $password,
                'email' => $account,
                'status' => 1
            ]);

            DB::commit();

            return $result;
        } catch (\Throwable $e) {
            // DB Transaction rollBack
            DB::rollBack();
            if (strpos($e->getMessage(), '\'admins_account_unique\'') !== false) {
                throw new ExceptionCode(ExceptionCode::ACCOUNT_EXISTS);
            } else {
                throw $e;
            }
        }
    }

    /**
     * Get a list of data for existing admins.
     *
     * @param int $perPage
     *
     * @return array
     */
    public function index(int $perPage = 15): array
    {
        /* Criteria Index */
        $this->pushCriteria(app('App\Criteria\Admin\User\IndexCriteria'));

        $result = $this->paginate($perPage);
        if (isset($result['meta']['pagination']['links'])) {
            unset($result['meta']['pagination']['links']);
        }
        return $result;
    }
    
    /**
     * Get data centered on existing admin's primary key id.
     *
     * @param int $id
     *
     * @return array
     * @throws \Exception
     */
    public function focusAdmin(int $id): array
    {
        $result = $this->find($id);

        return $result['data'];
    }

    /**
     * Disable focus admin.
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
     * Enable focus admin.
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
