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
use App\Libraries\Instances\Router\Sms;
use Phone;
use Lang;

/**
 * Class AuthRepositoryEloquent.
 *
 * @package namespace App\Repositories\Member;
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
        'name',
        'nickname'
    ];

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
    * Send phone verify code.
    *
    * @param string $phone
    *
    * @return bool
    * @throws \Exception
    */
    public function sentPhoneVerifyCode(string $phone): bool
    {
        if ($phone = Phone::parse($phone)->getNumber()) {
            $code = StorageCode::fill(TokenAuth::getAuthGuard($this->model()) . ':' . $phone, config('auth.phone_verifycode_ttl'));
            if (isset($code) && ($sms = Sms::route($phone)) && ($client = TokenAuth::getClient())) {
                $subject = Lang::dict('app', 'name', 'Service') . ' ' . Lang::dict('sms', 'subject.' . 'authcode', 'Authcode');
                $message = Lang::dict('app', 'name', 'Service') . ' ' . Lang::dict('sms', 'message.' . 'authcode', 'Authcode : :code', ['code' => $code]);
                $client->notify(new $sms($phone, $message, $subject));
                return true;
            }
        }
        
        return false;
    }

    /**
    * Obtain the verify code for the phone.
    *
    * @param string $phone
    *
    * @return int|null
    * @throws \Exception
    */
    public function getVerifyCode(string $phone): ?int
    {   
        if ($phone = Phone::parse($phone)->getNumber()) {
            return StorageCode::get(TokenAuth::getAuthGuard($this->model()) . ':' . $phone);
        }
        return null;
    }

    /**
    * Remove the verify code for the phone.
    *
    * @param string $phone
    *
    * @return bool
    * @throws \Exception
    */
    public function removeVerifyCode(string $phone):bool
    {   
        return StorageCode::forget(TokenAuth::getAuthGuard($this->model()) . ':' . $phone);
    }

    /**
    * Sign up for a new member account.
    *
    * @param string $account
    * @param string $password
    * @param string $phone
    * @param bool $agree
    *
    * @return object
    * @throws \Exception
    */
    public function register(string $account, string $password, string $phone, bool $agree = false): object
    {
        try {
            DB::beginTransaction();
            
            $result = $this->model->create([
                'account' => $account,
                'password' => $password,
                'phone' => $phone,
                'status' => 1,
                'agreed_at' => ($agree ? now() : null)
            ]);

            DB::commit();

            return $result;
        } catch (\Throwable $e) {
            DB::rollBack();
            if (strpos($e->getMessage(), '\'members_account_unique\'') !== false) {
                throw new ExceptionCode(ExceptionCode::ACCOUNT_EXISTS);
            } elseif (strpos($e->getMessage(), '\'members_phone_unique\'') !== false) {
                throw new ExceptionCode(ExceptionCode::PHONE_EXISTS);
            } elseif (strpos($e->getMessage(), '\'members_email_unique\'') !== false) {
                throw new ExceptionCode(ExceptionCode::EMAIL_EXISTS);
            } elseif (strpos($e->getMessage(), '\'members_nickname_unique\'') !== false) {
                throw new ExceptionCode(ExceptionCode::NICKNAME_EXISTS);
            } else {
                throw $e;
            }
        }
    }

    /**
    * Agree to membership terms.
    *
    * @param Auth $user
    *
    * @return void
    * @throws \Exception
    */
    public function agree(Auth $user)
    {
        if (!$user->exists) {
            throw new ModelNotFoundException('No query results for object model [' . get_class($user) . '] ');
        }

        if (isset($user->agreed_at) && $user->agreed_at >= SystemParameter::getValue('member_terms_updated_at')) {
            throw new ExceptionCode(ExceptionCode::TERMS_HAVE_AGREED);
        }

        $user->update([
            'agreed_at' => now()
        ]);
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
            try {
                $user->update($profile);
            } catch (\Throwable $e) {
                DB::rollBack();
                if (strpos($e->getMessage(), '\'members_phone_unique\'') !== false) {
                    throw new ExceptionCode(ExceptionCode::PHONE_EXISTS);
                } elseif (strpos($e->getMessage(), '\'members_email_unique\'') !== false) {
                    throw new ExceptionCode(ExceptionCode::EMAIL_EXISTS);
                } elseif (strpos($e->getMessage(), '\'members_nickname_unique\'') !== false) {
                    throw new ExceptionCode(ExceptionCode::NICKNAME_EXISTS);
                } else {
                    throw $e;
                }
            }
        } else {
            throw new ExceptionCode(ExceptionCode::UNSPECIFIED_DATA_COLUMN);
        }
    }

    /**
    * Edit user setting.
    *
    * @param Auth $user
    * @param array $setting
    *
    * @return void
    * @throws \Exception
    */
    public function editSetting(Auth $user, array $setting)
    {
        if (!$user->exists) {
            throw new ModelNotFoundException('No query results for object model [' . get_class($user) . '] ');
        }

        $options = array_keys($this->model->getSettingOptions());

        $setting = array_intersect_key($setting, array_flip($options));

        $setting = collect($setting)->map(function ($item, $key) {
            switch($key) {
                case 'pin';
                    return bcrypt($item);
                default:
                    return $item;
            }
        })->reject(function ($item) {
            return empty($item);
        })->all();

        if (count($setting) > 0) {
            $user->update([
                'setting' => $setting
            ]);
        } else {
            throw new ExceptionCode(ExceptionCode::UNSPECIFIED_DATA_COLUMN);
        }
    }
}
