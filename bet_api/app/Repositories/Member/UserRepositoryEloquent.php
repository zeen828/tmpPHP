<?php

namespace App\Repositories\Member;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Member\UserRepository;
use App\Entities\Member\User;
use App\Validators\Member\UserValidator;
use App\Exceptions\Member\UserExceptionCode as ExceptionCode;
use DB;
use App\Entities\Member\Auth;

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
     * Login or register a member account.
     *
     * @param string $sourceType
     * @param string $sourceId
     * @param string $account
     * @param string $oauth_token
     * @param string $uid
     *
     * @return object
     * @throws \Exception
     */
    public function loginRegister(string $sourceType, string $sourceId, string $account, string $oauth_token, string $parent_id): object
    {
        try {
            /* login get member user info */
            $result = Auth::where([
                'source_type' => $sourceType,
                'source_id' => $sourceId,
                'account' => $sourceId . '_' . $account,
            ])->first();

            if (empty($result)) {
                if (empty($parent_id)) {
                    $parent_id = 0;
                }
                /* register member user */
                DB::beginTransaction();
            
                $result = Auth::create([
                    'source_type' => $sourceType,
                    'source_id' => $sourceId,
                    'parent_id' => $parent_id,
                    'parent_level' => 0,
                    'level' => 0,
                    'account' => $sourceId . '_' . $account,
                    'oauth_token' => $oauth_token,
                    'freeze' => 0,
                    'status' => 1,
                ]);
    
                DB::commit();
            }else{
                $updata = [];
                // if($result->parent_id == '0' && !empty($parent_id)){
                //     $updata['parent_id'] = $parent_id;
                // }
                if(!empty($oauth_token)){
                    $updata['oauth_token'] = $oauth_token;
                }
                if(count($updata) >= 1){
                    /* update token */
                    $result->update($updata);
                }
            }

            return $result;
        } catch (\Throwable $e) {
            // DB Transaction rollBack
            DB::rollBack();
            if (strpos($e->getMessage(), '\'members_account_unique\'') !== false) {
                throw new ExceptionCode(ExceptionCode::ACCOUNT_EXISTS);
            } else {
                throw $e;
            }
        }
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
