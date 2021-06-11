<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Member\AuthCreateRequest;
use App\Http\Requests\Member\AuthUpdateRequest;
use App\Http\Responses\Member\AuthCreateResponse;
use App\Http\Responses\Member\AuthUpdateResponse;
use App\Exceptions\Member\AuthExceptionCode as ExceptionCode;
use App\Repositories\Member\AuthRepository;
use App\Validators\Member\AuthValidator;
use App\Exceptions\Jwt\AuthExceptionCode;
use TokenAuth;

/**
 * @group
 *
 * Member Auth
 *
 * @package namespace App\Http\Controllers\Member;
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
     * Change Extract Password
     *
     * User change the extract password.
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
    public function changeExtractPassword(AuthUpdateRequest $request, AuthUpdateResponse $response)
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
                $this->repository->changeExtractPassword($user, $input['password']);
                return $response->success();
            }
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Show Member User Profile
     *
     * Show the member user profile.
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
     * level | INT | User level
     * account | STR | User account
     * created_at | STR | Datetime when the user was created
     * updated_at | STR | User last updated datetime
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "uid": "6283515611",
     *        "level": "0",
     *        "account": "1_422652883",
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