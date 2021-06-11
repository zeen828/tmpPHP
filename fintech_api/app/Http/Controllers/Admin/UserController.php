<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Responses\Admin\UserCreateResponse;
use App\Http\Responses\Admin\UserUpdateResponse;
use App\Exceptions\Admin\UserExceptionCode as ExceptionCode;
use App\Repositories\Admin\UserRepository;
use App\Validators\Admin\UserValidator;
use DB;
use App\Notifications\User\Auth\Login;
use TokenAuth;
use App\Entities\Admin\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Str;

/**
 * @group
 *
 * Manage Admin
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * UserController constructor.
     *
     * @param UserRepository $repository
     * @param UserValidator $validator
     */
    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Admin Index
     *
     * Get the admin user index.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * uid | STR | User serial id
     * account | STR | User pseudo account
     * email | STR | User e-mail
     * name | STR | User name
     * status | BOOL | User status false: Disable true: Enable
     * created_at | STR | Datetime when the user was created
     * updated_at | STR | User last updated datetime
     *
     * meta.pagination :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * total | INT | Total number of data
     * count | INT | Number of data displayed
     * per_page | INT | Number of displayed data per page
     * current_page | INT | Current page number
     * total_pages | INT | Total pages
     *
     * @queryParam start Start range of query creation date Example: 2018-10-01
     * @queryParam end End range of query creation date Example: 2020-10-30
     * @queryParam page required Page number Example: 1
     * @queryParam rows Per page rows defaults to 15 Example: 15
     *
     * @response
     * {
     *    "success": true,
     *    "data": [
     *        {
     *            "uid": "6281294583",
     *            "account": "admi****",
     *            "email": "admin@system.com",
     *            "name": "admin",
     *            "status": true,
     *            "created_at": "2018-11-26 11:41:32",
     *            "updated_at": "2018-11-26 11:41:32"
     *        },
     *        {
     *            "uid": "6282215437",
     *            "account": "tyle****",
     *            "email": "tyler@gmail.com",
     *            "name": "tyler",
     *            "status": true,
     *            "created_at": "2018-11-26 11:41:32",
     *            "updated_at": "2018-11-26 11:41:32"
     *        },
     *        {
     *            "uid": "6283515611",
     *            "account": "jsio****",
     *            "email": "json0121@gmail.com",
     *            "name": "json",
     *            "status": true,
     *            "created_at": "2018-11-26 11:41:32",
     *            "updated_at": "2018-11-26 11:41:32"
     *        }
     *    ],
     *    "meta": {
     *        "pagination": {
     *            "total": 3,
     *            "count": 3,
     *            "per_page": 15,
     *            "current_page": 1,
     *            "total_pages": 1
     *        }
     *    }
     * }
     *
     * @param UserCreateRequest $request
     * @param UserCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserCreateRequest $request, UserCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);
        return $response->success($this->repository->index($perPage));
    }

    /**
     * Admin Info
     *
     * Get the admin user info.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * uid | STR | User serial id
     * account | STR | User pseudo account
     * email | STR | User e-mail
     * name | STR | User name
     * status | BOOL | User status false: Disable true: Enable
     * authority | ARR | User APIs authority
     * created_at | STR | Datetime when the user was created
     * updated_at | STR | User last updated datetime
     *
     * @urlParam uid required User serial id Example: 6281294583
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "uid": "6281294583",
     *        "account": "admi****",
     *        "email": "admin@system.com",
     *        "name": "admin",
     *        "status": true,
     *        "authority": [
     *              "auth.token.create",
     *              "auth.token.refresh",
     *              "auth.token.revoke",
     *              "auth.user.login",
     *              "auth.user.signature.login",
     *              "auth.user.logout",
     *              "auth.read.service",
     *              "auth.user.types",
     *              "auth.user.signature"
     *        ],
     *        "created_at": "2018-11-26 11:41:32",
     *        "updated_at": "2018-11-26 11:41:32"
     *    }
     * }
     *
     * @param int $id
     * @param UserCreateRequest $request
     * @param UserCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function read($id, UserCreateRequest $request, UserCreateResponse $response)
    {
        return $response->success($this->repository->focusAdmin($id));
    }

    /**
     * Logon Admin
     *
     * Register an admin user and send an authentication email.
     *
     * ### Response Body
     *
     * success : true
     *
     * @bodyParam account STR required User account Example: {account}
     *
     * @response
     * {
     *    "success": true
     * }
     *
     * @param UserCreateRequest $request
     * @param UserCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logon(UserCreateRequest $request, UserCreateResponse $response)
    {
        /* Register */
        $credentials = $request->only([
            'account'
        ]);

        DB::beginTransaction();
        /* Get user model */
        $user = $this->repository->register($credentials['account'], Str::random(32), true);
        /* Send to admin email */
        $user->notify((new Login(config('admin.logon_redirect')))->assignVar(config('admin.logon_redirect_query_var'))->assignMail($user->account));

        DB::commit();

        return $response->success();
    }

    /**
     * Resend Admin Auth Mail
     *
     * Resend the administrator authentication signed message.
     *
     * ### Response Body
     *
     * success : true
     *
     * @bodyParam reset BOOL required Reset auth ( 1 or 0 ) Example: {reset}
     * 
     * @urlParam uid required User serial id Example: 6281294583
     * 
     * @response
     * {
     *    "success": true
     * }
     *
     * @param int $id
     * @param UserCreateRequest $request
     * @param UserCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendAuthMail($id, UserCreateRequest $request, UserCreateResponse $response)
    {
        /* Check operator */
        if (($user = TokenAuth::getUser(Auth::class)) && $user->id == $id) {
            throw new ExceptionCode(ExceptionCode::INOPERABLE_USER);
        }
        /* Get user model */
        if ($user = Auth::find($id)) {
            /* Reset auth */
            if ($request->input('reset')) {
                $user->password = Str::random(32);
                $user->unique_auth = '';
                $user->save();
            }
            /* Send to admin email */
            $user->notify((new Login(config('admin.resend_auth_redirect')))->assignVar(config('admin.resend_auth_redirect_query_var'))->assignMail($user->account));
            return $response->success();
        }
        throw new ModelNotFoundException('No query results for model [' . Auth::class . '] ' . $id);
    }

    /**
     * Disable Admin
     *
     * Disable the admin user for the service.
     *
     * ### Response Body
     *
     * success : true
     *
     * @urlParam uid required User serial id Example: 6281294583
     *
     * @response
     * {
     *    "success": true
     * }
     *
     * @param int $id
     * @param UserUpdateRequest $request
     * @param UserUpdateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function disable($id, UserUpdateRequest $request, UserUpdateResponse $response)
    {
        /* Check operator */
        if (($user = TokenAuth::getUser(Auth::class)) && $user->id == $id) {
            throw new ExceptionCode(ExceptionCode::INOPERABLE_USER);
        }

        $this->repository->focusDisable($id);

        return $response->success();
    }

    /**
     * Enable Admin
     *
     * Enable the admin user for the service.
     *
     * ### Response Body
     *
     * success : true
     *
     * @urlParam uid required User serial id Example: 6281294583
     *
     * @response
     * {
     *    "success": true
     * }
     *
     * @param int $id
     * @param UserUpdateRequest $request
     * @param UserUpdateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable($id, UserUpdateRequest $request, UserUpdateResponse $response)
    {
        /* Check operator */
        if (($user = TokenAuth::getUser(Auth::class)) && $user->id == $id) {
            throw new ExceptionCode(ExceptionCode::INOPERABLE_USER);
        }

        $this->repository->focusEnable($id);

        return $response->success();
    }
}