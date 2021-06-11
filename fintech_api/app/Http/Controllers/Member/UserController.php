<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Member\UserCreateRequest;
use App\Http\Requests\Member\UserUpdateRequest;
use App\Http\Responses\Member\UserCreateResponse;
use App\Http\Responses\Member\UserUpdateResponse;
use App\Exceptions\Member\UserExceptionCode as ExceptionCode;
use App\Repositories\Member\UserRepository;
use App\Validators\Member\UserValidator;
use SystemParameter;
use App\Exceptions\System\ParameterExceptionCode;
use Carbon;

/**
 * @group
 *
 * Manage Member
 *
 * @package namespace App\Http\Controllers\Member;
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
     * Member Index
     *
     * Get the member user index.
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
     * status | BOOL | User status false: Disable true: Enable
     * agreed_at | STR | Datetime when the user agreed to the membership terms of service.
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
     *            "phone": "+886930684635",
     *            "email": "",
     *            "name": "",
     *            "nickname": "",
     *            "setting": {
     *                "bank": "",
     *                "line": ""
     *            },
     *            "status": true,
     *            "agreed_at": "2018-11-26 11:50:32",
     *            "created_at": "2018-11-26 11:41:32",
     *            "updated_at": "2018-11-26 11:41:32"
     *        },
     *        {
     *            "uid": "6282215437",
     *            "phone": "+886930684685",
     *            "email": "",
     *            "name": "",
     *            "nickname": "",
     *            "setting": {
     *                "bank": "",
     *                "line": ""
     *            },
     *            "status": true,
     *            "agreed_at": "2018-11-26 11:51:32",
     *            "created_at": "2018-11-26 11:41:32",
     *            "updated_at": "2018-11-26 11:41:32"
     *        },
     *        {
     *            "uid": "6283515611",
     *            "phone": "+886930684665",
     *            "email": "",
     *            "name": "",
     *            "nickname": "",
     *            "setting": {
     *                "bank": "",
     *                "line": ""
     *            },
     *            "status": true,
     *            "agreed_at": "2018-11-26 11:52:32",
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
     * Member Info
     *
     * Get the member user info.
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
     * status | BOOL | User status false: Disable true: Enable
     * agreed_at | STR | Datetime when the user agreed to the membership terms of service.
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
     *        "phone": "+886930684635",
     *        "email": "",
     *        "name": "",
     *        "nickname": "",
     *        "setting": {
     *             "bank": "",
     *             "line": ""
     *        },
     *        "status": true,
     *        "agreed_at": "2018-11-26 11:50:32",
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
        return $response->success($this->repository->focusMember($id));
    }

    /**
     * Disable Member
     *
     * Disable the member user for the service.
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
        $this->repository->focusDisable($id);

        return $response->success();
    }

    /**
     * Enable Member
     *
     * Enable the member user for the service.
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
        $this->repository->focusEnable($id);

        return $response->success();
    }

    /**
     * Update Terms Timestamp
     *
     * Update membership terms UTC timestamp time for now.
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
     * @param UserUpdateRequest $request
     * @param UserUpdateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function touchTermsTimestamp(UserUpdateRequest $request, UserUpdateResponse $response)
    {
        /* Update system parameter */
        if (! SystemParameter::setValue('member_terms_updated_at', Carbon::now())) {
            throw new ParameterExceptionCode(ParameterExceptionCode::REWRITE_PARAMETER_VALUE_FAIL);
        }
        
        return $response->success();
    }
}