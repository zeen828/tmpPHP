<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Admin\AuthCreateRequest;
use App\Http\Requests\Admin\AuthUpdateRequest;
use App\Http\Responses\Admin\AuthCreateResponse;
use App\Http\Responses\Admin\AuthUpdateResponse;
use App\Exceptions\Admin\AuthExceptionCode as ExceptionCode;
use App\Repositories\Admin\AuthRepository;
use App\Validators\Admin\AuthValidator;
use App\Exceptions\Jwt\AuthExceptionCode;
use TokenAuth;
use Hash;

/**
 * @group
 *
 * Admin Auth
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class AuthController extends Controller
{
    /**
     * @var AuthRepository
     */
    protected $repository;

    /**
     * @var AuthValidator
     */
    protected $validator;

    /**
     * AuthController constructor.
     *
     * @param AuthRepository $repository
     * @param AuthValidator $validator
     */
    public function __construct(AuthRepository $repository, AuthValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
    * Edit Profile
    *
    * Edit user profile.
    *
    * ### Response Body
    *
    * success : true
    *
    * @bodyParam email STR User e-mail Example: {email}
    * @bodyParam name STR User name Example: {name}
    *
    * @response
    * {
    *    "success": true
    * }
    *
    * @param AuthUpdateRequest $request
    * @param AuthUpdateResponse $response
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function editProfile(AuthUpdateRequest $request, AuthUpdateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser($this->repository->model())) {
            /* Input profile */
            $profile = $request->only([
                'email',
                'name'
            ]);
            /* Change user profile */
            $this->repository->editProfile($user, $profile);
            return $response->success();
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
    * Change Password
    *
    * User change the password.
    *
    * ### Response Body
    *
    * success : true
    *
    * @bodyParam password STR required User new password Example: {password}
    * @bodyParam password_confirmation STR required User new password confirmation Example: {password_confirmation}
    *
    * @response
    * {
    *    "success": true
    * }
    *
    * @param AuthUpdateRequest $request
    * @param AuthUpdateResponse $response
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function changePassword(AuthUpdateRequest $request, AuthUpdateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser($this->repository->model())) {
            /* Input */
            $input = $request->only([
                'password',
                'password_confirmation'
            ]);
            /* Check password */
            if ($input['password'] !== $input['password_confirmation']) {
                throw new ExceptionCode(ExceptionCode::PASSWORD_CONFIRM_FAIL);
            } else {
                /* Change pin code */
                $this->repository->changePassword($user, $input['password']);
                return $response->success();
            }
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Show Admin Profile
     *
     * Show the admin user profile.
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
     * email | STR | User e-mail
     * name | STR | User name
     * authority | ARR | User APIs authority
     * created_at | STR | Datetime when the user was created
     * updated_at | STR | User last updated datetime
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "uid": "6281294583",
     *        "email": "admin@system.com",
     *        "name": "admin",
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
     * @param AuthCreateRequest $request
     * @param AuthCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(AuthCreateRequest $request, AuthCreateResponse $response)
    {
        if ($user = TokenAuth::getUser($this->repository->model())) {
            /* Transformer */
            $transformer = app($this->repository->presenter())->getTransformer();
            /* Array Info */
            $info = $transformer->transform($user);

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}
