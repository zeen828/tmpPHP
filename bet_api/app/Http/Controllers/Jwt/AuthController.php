<?php

namespace App\Http\Controllers\Jwt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Jwt\AuthCreateRequest;
use App\Http\Requests\Jwt\AuthUpdateRequest;
use App\Http\Responses\Jwt\AuthCreateResponse;
use App\Http\Responses\Jwt\AuthUpdateResponse;
use App\Exceptions\Jwt\AuthExceptionCode as ExceptionCode;
use App\Repositories\Jwt\AuthRepository;
use App\Validators\Jwt\AuthValidator;
use TokenAuth;
use Hash;

/**
 * @group
 *
 * Auth Token
 *
 * @package namespace App\Http\Controllers\Jwt;
 */
class AuthController extends Controller
{
    /**
     *
     * @var AuthRepository
     */
    protected $repository;
    
    /**
     *
     * @var AuthValidator
     */
    protected $validator;

    /**
     * AuthController constructor.
     *
     * @param AuthValidator $validator
     */
    public function __construct(AuthRepository $repository, AuthValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Get Access Token
     *
     * Login with client service to get the access token.
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
     * @bodyParam client_id STR required Client id Example: {client_id}
     * @bodyParam client_secret STR required Client secret Example: {client_secret}
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiWnZYVk9Ib2JRRzhKSnZqUCIsInN1YiI6MX0.9ZwtS9G2FyEPypmYczvZWuqUykEtEX2foDpYEXuTurc",
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
    public function token(AuthCreateRequest $request, AuthCreateResponse $response)
    {
        /* Check account mode */
        $accountName = $this->repository->model()::getLoginIdentifierName();
        if (! isset($accountName[0])) {
            throw new ExceptionCode(ExceptionCode::NO_PERMISSION);
        }
        /* Get service credentials */
        $credentials = $request->only([
            'client_id',
            'client_secret'
        ]);
        /* Check service */
        if ($client = $this->repository->model()::where($accountName, $credentials['client_id'])->first()) {
            if (!Hash::check($credentials['client_secret'], $client->getAuthPassword())) {
                throw new ExceptionCode(ExceptionCode::CLIENT_AUTH_FAIL);
            } else {
                /* Check auth client status */
                $client->verifyHoldStatusOnFail();
                /* Get client token */
                if ($token = TokenAuth::loginClient($client)) {
                    $source = [
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'expires_in' => $client->getTTL() * 60
                    ];

                    return $response->success($source);
                }
                throw new ExceptionCode(ExceptionCode::TOKEN_CREATE_FAIL);
            }
        }
        throw new ExceptionCode(ExceptionCode::CLIENT_NON_EXIST);
    }

    /**
     * Show Service Profile
     *
     * Show the client service profile for the current access token.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * app_id | STR | Client serial id
     * name | STR | Client name
     * ban | INT | Client ban number
     * description | STR | Client ban description
     * created_at | STR | Datetime when the client was created
     * updated_at | STR | Client last updated datetime
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "app_id": "6398211294583",
     *        "name": "admin",
     *        "ban": 0,
     *        "description": "Global Service",
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
    public function service(AuthCreateRequest $request, AuthCreateResponse $response)
    {
        /* Transformer */
        $transformer = app($this->repository->presenter())->getTransformer();
        /* Array Info */
        $info = $transformer->transform(TokenAuth::getClient());

        return $response->success($info);
    }

    /**
     * Refresh Access Token
     *
     * Refresh the current access token.
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
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
     *        "token_type": "bearer",
     *        "expires_in": 3660
     *    }
     * }
     *
     * @param AuthUpdateRequest $request
     * @param AuthUpdateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(AuthUpdateRequest $request, AuthUpdateResponse $response)
    {
        /* Refresh token */
        if ($token = TokenAuth::refresh()) {
            $source = [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => TokenAuth::getTTL() * 60
            ];

            return $response->success($source);
        }
        throw new ExceptionCode(ExceptionCode::TOKEN_CREATE_FAIL);
    }

    /**
     * Revoke Access Token
     *
     * Revoke the current access token.
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
     * @param AuthUpdateRequest $request
     * @param AuthUpdateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function revoke(AuthUpdateRequest $request, AuthUpdateResponse $response)
    {
        /* Invalidate token */
        if (TokenAuth::revoke()) {
            return $response->success();
        }
        throw new ExceptionCode(ExceptionCode::AUTH_FAIL);
    }

    /**
     * Login Types
     *
     * Get a list of user types for login.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * type | STR | Type code
     * description | STR | Type about description
     *
     * @response
     * {
     *    "success": true,
     *    "data": [
     *        {
     *            "type": "member",
     *            "description": "Member User"
     *        },
     *        {
     *            "type": "admin",
     *            "description": "Admin User"
     *        }
     *    ]
     * }
     *
     * @param AuthCreateRequest $request
     * @param AuthCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userTypes(AuthCreateRequest $request, AuthCreateResponse $response)
    {
        $types = TokenAuth::userTypes([
            'type',
            'description'
        ]);
        /* Check ban */
        $restrict = config('ban.release.' . TokenAuth::getClient()->ban . '.restrict_access_guards');
        if (is_array($restrict) && count($restrict) > 0) {
            $types = array_intersect_key($types, array_flip($restrict));
        }
        return $response->success([
            'data' => array_values($types)
        ]);
    }

    /**
     * Login Identity
     *
     * Login with user credentials and return the user's identity access token.
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
     * @urlParam type required User type code Example: admin
     * @bodyParam account STR required User account Example: {account}
     * @bodyParam password STR required User password Example: {password}
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
     * @param array $type
     * @param AuthCreateRequest $request
     * @param AuthCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($type, AuthCreateRequest $request, AuthCreateResponse $response)
    {
        /* Check account mode */
        $accountName = $type['class']::getLoginIdentifierName();
        if (! isset($accountName[0])) {
            throw new ExceptionCode(ExceptionCode::NO_PERMISSION);
        }
        /* Get user credentials */
        $credentials = $request->only([
            'account',
            'password'
        ]);
        /* Check user */
        if ($user = $type['class']::where($accountName, $credentials['account'])->first()) {
            if (!Hash::check($credentials['password'], $user->getAuthPassword())) {
                throw new ExceptionCode(ExceptionCode::USER_AUTH_FAIL);
            } else {
                /* Check auth user status */
                $user->verifyHoldStatusOnFail();
                /* Get user token */
                if ($token = TokenAuth::loginUser($user)) {
                    $source = [
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'expires_in' => $user->getTTL() * 60
                    ];

                    return $response->success($source);
                }
                throw new ExceptionCode(ExceptionCode::TOKEN_CREATE_FAIL);
            }
        }
        throw new ExceptionCode(ExceptionCode::USER_NON_EXIST);
    }

    /**
     * Logout Identity
     *
     * Revoke the current user's identity access token and return client access token.
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
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ8.eyJpc3MiOiJodHRwOlwvXC8sb2NhbGhvc3RcL2FwaVwvdjFcL2F1dGhcL3Rva2VuXC9yZWZyZXNoIiwiaWF0IjoxNTQzMjI2NzgzLCJleHAiOjE1NDMyMjY4NDMsIm5iZiI6MTU0MzIyNjc4MywianRpIjoiMzRMbUZ5a3hQUDR3eWg0SSIsInN1YiI6MX0.GcZ8vExcbjWRTPQ_kOlBUg3h32ph-4viXIugApqjsTA",
     *        "token_type": "bearer",
     *        "expires_in": 3660
     *    }
     * }
     *
     * @param AuthUpdateRequest $request
     * @param AuthUpdateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(AuthUpdateRequest $request, AuthUpdateResponse $response)
    {
        /* User Logout */
        if ($token = TokenAuth::logoutUser()) {
            /* Return authorization client access token */
            $source = [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => TokenAuth::getTTL() * 60
            ];

            return $response->success($source);
        }
        throw new ExceptionCode(ExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Authorization Signature
     *
     * Get the user code used for signature authorization login.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * signature | STR | Authorized signature code
     * expires_in | INT | Authorized signature code valid seconds
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "signature": "8466b336802941ac8df1bd3173bdeb8de1fabcec5fbb036f0c08c550a738b182abab2d07",
     *        "expires_in": 180
     *    }
     * }
     *
     * @param AuthCreateRequest $request
     * @param AuthCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userSignature(AuthCreateRequest $request, AuthCreateResponse $response)
    {
        /* Check user auth */
        if ($user = TokenAuth::getUser()) {
            /* Get auth signature code */
            if ($code = TokenAuth::injectUserSignature($user)) {
                /* Return authorization signature code */
                $source = [
                    'signature' => $code,
                    'expires_in' => $user->getUTSTTL() * 60
                ];

                return $response->success($source);
            }
            throw new ExceptionCode(ExceptionCode::SIGNATURE_CREATE_FAIL);
        }
        throw new ExceptionCode(ExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Login Signature
     *
     * Login with user authorized signature code and return the user's identity access token.
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
     * @bodyParam signature STR required User authorized signature code Example: {signature}
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
    public function loginSignature(AuthCreateRequest $request, AuthCreateResponse $response)
    {
        /* Get user model */
        if ($user = TokenAuth::getUserBySignature($request->input('signature'))) {
            /* Check auth user status */
            $user->verifyHoldStatusOnFail();
            /* Get user token */
            if ($token = TokenAuth::loginUser($user)) {
                $source = [
                    'uid' => $user->uid,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => $user->getTTL() * 60
                ];

                return $response->success($source);
            }
            throw new ExceptionCode(ExceptionCode::TOKEN_CREATE_FAIL);
        }
        throw new ExceptionCode(ExceptionCode::USER_AUTH_FAIL);
    }
}