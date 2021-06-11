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
use Hash;
use DB;

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
     * Phone Verify Code
     *
     * Send phone SMS verify code.
     *
     * ### Response Body
     *
     * success : true
     *
     * @bodyParam phone STR required User phone Example: {phone}
     *
     * @response
     * {
     *    "success": true
     * }
     *
     * @param AuthCreateRequest $request
     * @param AuthCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyCode(AuthCreateRequest $request, AuthCreateResponse $response)
    {
        $phone = $request->input('phone');

        if (! $this->repository->sentPhoneVerifyCode($phone)) {
            throw new ExceptionCode(ExceptionCode::PHONE_VERIFYCODE_SEND_FAIL);
        }

        return $response->success();
    }

    /**
     * Phone Login
     *
     * Login with phone authorization.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * access_token | STR | API access token
     * token_type | STR | API access token type
     * expires_in | INT | API access token valid seconds
     *
     * @bodyParam phone STR required User phone Example: {phone}
     * @bodyParam verifycode INT required User phone verifycode Example: {verifycode}
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ8.eyJpc6MiOiJodHRwOlwvXC8sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
     *        "token_type": "bearer",
     *        "expires_in": 3660
     *    }
     * }
     *
     * @param AuthCreateRequest $request
     * @param AuthCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function phoneLogin(AuthCreateRequest $request, AuthCreateResponse $response)
    {
        /* Input */
        $credentials = $request->only([
            'phone',
            'verifycode'
        ]);
        $verifyCode = $this->repository->getVerifyCode($credentials['phone']);
        /* Verify verifycode */
        if (! $verifyCode || $verifyCode != $credentials['verifycode']) {
            throw new ExceptionCode(ExceptionCode::PHONE_VERIFYCODE_FAIL);
        }
        $user = $this->repository->model()::where('phone', $credentials['phone'])->first();
        if ($user) {
            $user->verifyHoldStatusOnFail();
            /* Get user token */
            if ($token = TokenAuth::loginUser($user)) {
                $source = [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => TokenAuth::getTTL() * 60
                ];
                /* Remove verifycode */
                $this->repository->removeVerifyCode($credentials['phone']);

                return $response->success($source);
            }
            throw new AuthExceptionCode(AuthExceptionCode::TOKEN_CREATE_FAIL);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Logon Identity
     *
     * Logon with user credentials and return the user's identity access token.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * access_token | STR | API access token
     * token_type | STR | API access token type
     * expires_in | INT | API access token valid seconds
     *
     * @bodyParam account STR required User account Example: {account}
     * @bodyParam password STR required User new password Example: {password}
     * @bodyParam password_confirmation STR required User new password confirmation Example: {password_confirmation}
     * @bodyParam phone STR required User phone Example: {phone}
     * @bodyParam verifycode INT required User phone verifycode Example: {verifycode}
     * @bodyParam agree_terms BOOL required User agree terms ( 1 or 0 ) Example: {agree_terms}
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ8.eyJpc6MiOiJodHRwOlwvXC8sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
     *        "token_type": "bearer",
     *        "expires_in": 3660
     *    }
     * }
     *
     * @param AuthCreateRequest $request
     * @param AuthCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logon(AuthCreateRequest $request, AuthCreateResponse $response)
    {
        /* Register */
        $credentials = $request->only([
            'account',
            'password',
            'password_confirmation',
            'phone',
            'verifycode',
            'agree_terms'
        ]);
        $verifyCode = $this->repository->getVerifyCode($credentials['phone']);
        /* Verify verifycode */
        if (! $verifyCode || $verifyCode != $credentials['verifycode']) {
            throw new ExceptionCode(ExceptionCode::PHONE_VERIFYCODE_FAIL);
        }
        /* Verify agree status */
        if (! $credentials['agree_terms']) {
            throw new ExceptionCode(ExceptionCode::TERMS_NOT_AGREED);
        }
        /* Check password */
        if ($credentials['password'] !== $credentials['password_confirmation']) {
            throw new ExceptionCode(ExceptionCode::PASSWORD_CONFIRM_FAIL);
        }
        DB::beginTransaction();
        /* Get user model */
        $user = $this->repository->register($credentials['account'], $credentials['password'], $credentials['phone'], true);
        /* Get user token */
        if ($token = TokenAuth::loginUser($user)) {
            $source = [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => TokenAuth::getTTL() * 60
            ];
            /* Remove verifycode */
            $this->repository->removeVerifyCode($credentials['phone']);

            DB::commit();

            return $response->success($source);
        }
        throw new AuthExceptionCode(AuthExceptionCode::TOKEN_CREATE_FAIL);
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
    * @bodyParam nickname STR User nickname Example: {nickname}
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
                'name',
                'nickname'
            ]);
            /* Change user profile */
            $this->repository->editProfile($user, $profile);
            return $response->success();
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
    * Edit Setting
    *
    * Edit user setting.
    *
    * ### Response Body
    *
    * success : true
    *
    * @bodyParam bank STR User bank card number Example: {bank}
    * @bodyParam line STR User line id Example: {line}
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
    public function editSetting(AuthUpdateRequest $request, AuthUpdateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser($this->repository->model())) {
            /* Input setting */
            $setting = $request->only([
                'bank',
                'line'
            ]);
            /* Change user setting */
            $this->repository->editSetting($user, $setting);
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
    * Change Pin
    *
    * User change the pin code.
    *
    * ### Response Body
    *
    * success : true
    *
    * @bodyParam pin STR required User pin code Example: {pin}
    * @bodyParam pin_confirmation STR required User pin code confirmation Example: {pin_confirmation}
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
    public function changePin(AuthUpdateRequest $request, AuthUpdateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser($this->repository->model())) {
            /* Input */
            $input = $request->only([
                'pin',
                'pin_confirmation'
            ]);
            /* Verify password */
            if ($input['pin'] !== $input['pin_confirmation']) {
                throw new ExceptionCode(ExceptionCode::PIN_CONFIRM_FAIL);
            } else {
                /* Change pin code */
                $this->repository->editSetting($user, ['pin' => $input['pin']]);
                return $response->success();
            }
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Agree Terms
     *
     * User authorizes service agreement.
     *
     * ### Response Body
     *
     * success : true
     *
     * @response
     * {
     *    "success": true
     * }
     *
     * @param AuthCreateRequest $request
     * @param AuthCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function agree(AuthCreateRequest $request, AuthCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser($this->repository->model())) {
            /* User agree */
            $this->repository->agree($user);

            return $response->success();
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
    
    /**
     * Show Member Profile
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
     * phone | STR | User phone
     * email | STR | User e-mail
     * name | STR | User name
     * nickname | STR | User nickname
     * setting.bank | STR | User bank card number
     * setting.line | STR | User line id
     * agreed_at | STR | Datetime when the user agreed to the membership terms of service.
     * created_at | STR | Datetime when the user was created
     * updated_at | STR | User last updated datetime
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "uid": "6281294583",
     *        "phone": "+886930684635",
     *        "email": "",
     *        "name": "",
     *        "nickname": "",
     *        "setting": {
     *             "bank": "",
     *             "line": ""
     *        },
     *        "agreed_at": "2018-11-26 11:41:32",
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