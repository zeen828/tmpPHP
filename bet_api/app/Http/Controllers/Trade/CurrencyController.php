<?php

namespace App\Http\Controllers\Trade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Trade\CurrencyCreateRequest;
use App\Http\Requests\Trade\CurrencyUpdateRequest;
use App\Http\Responses\Trade\CurrencyCreateResponse;
use App\Http\Responses\Trade\CurrencyUpdateResponse;
use App\Exceptions\Trade\OperateExceptionCode as ExceptionCode;
use App\Repositories\Trade\CurrencyRepository;
use App\Validators\Trade\CurrencyValidator;
use App\Exceptions\Jwt\AuthExceptionCode;
use TokenAuth;

/**
 * @group
 *
 * Trade Currency
 *
 * @package namespace App\Http\Controllers\Trade;
 */
class CurrencyController extends Controller
{
    /**
     * @var CurrencyRepository
     */
    protected $repository;

    /**
     * @var CurrencyValidator
     */
    protected $validator;

    /**
     * CurrencyController constructor.
     *
     * @param CurrencyRepository $repository
     * @param CurrencyValidator $validator
     */
    public function __construct(CurrencyRepository $repository, CurrencyValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Currency Account Index
     *
     * Get the currency account index.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * currency | STR | Currency type code
     * account | STR | Currency account serial id
     * amount | STR | Total account balance
     * holder_type | STR | Account holder type code
     * holder_id | STR | Account holder uid
     * created_at | STR | Datetime when the account was created
     * updated_at | STR | Account last updated datetime
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
     * @urlParam type required Trade currency type code Example: crystal
     *
     * @response
     * {
     *    "success": true,
     *    "data": [
     *        {
     *            "currency": "crystal",
     *            "account": "100022058",
     *            "amount": 100,
     *            "holder_type": "member",
     *            "holder_id": "1294583",
     *            "created_at": "2018-11-26 11:41:32",
     *            "updated_at": "2020-01-01 10:10:00"
     *        },
     *        {
     *            "currency": "crystal",
     *            "account": "200920499",
     *            "amount": 300,
     *            "holder_type": "member",
     *            "holder_id": "2215437",
     *            "created_at": "2018-11-26 11:41:32",
     *            "updated_at": "2020-01-01 10:10:00"
     *        },
     *        {
     *            "currency": "crystal",
     *            "account": "300830084",
     *            "amount": 0,
     *            "holder_type": "member",
     *            "holder_id": "3515611",
     *            "created_at": "2018-11-26 11:41:32",
     *            "updated_at": "2020-01-01 10:10:00"
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
     * @param array $type
     * @param CurrencyCreateRequest $request
     * @param CurrencyCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($type, CurrencyCreateRequest $request, CurrencyCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);
        return $response->success($this->repository->index($type['type'], $perPage));
    }

    /**
     * Currency Account Balance
     *
     * Get the currency account balance.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * currency | STR | Currency type code
     * account | STR | Currency account serial id
     * amount | STR | Total account balance
     * holder_type | STR | Account holder type code
     * holder_id | STR | Account holder uid
     * created_at | STR | Datetime when the account was created
     * updated_at | STR | Account last updated datetime
     *
     * @urlParam type required Trade currency type code Example: crystal
     * @urlParam account required Currency account serial id Example: 100022058
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "currency": "crystal",
     *        "account": "100022058",
     *        "amount": 100,
     *        "holder_type": "member",
     *        "holder_id": "1294583",
     *        "created_at": "2018-11-26 11:41:32",
     *        "updated_at": "2020-01-01 10:10:00"
     *    }
     * }
     *
     * @param array $type
     * @param int $id
     * @param CurrencyCreateRequest $request
     * @param CurrencyCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function read($type, $id, CurrencyCreateRequest $request, CurrencyCreateResponse $response)
    {
        return $response->success($this->repository->focusAccountId($type['type'], $id));
    }

    /**
     * My Currency Account Balance
     *
     * Get the user's currency account balance.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * currency | STR | Currency type code
     * account | STR | Currency account serial id
     * amount | STR | Total account balance
     * holder_type | STR | Account holder type code
     * holder_id | STR | Account holder uid
     * created_at | STR | Datetime when the account was created
     * updated_at | STR | Account last updated datetime
     *
     * @urlParam type required Trade currency type code Example: crystal
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "currency": "crystal",
     *        "account": "100022058",
     *        "amount": 100,
     *        "holder_type": "member",
     *        "holder_id": "1294583",
     *        "created_at": "2018-11-26 11:41:32",
     *        "updated_at": "2020-01-01 10:10:00"
     *    }
     * }
     *
     * @param array $type
     * @param CurrencyCreateRequest $request
     * @param CurrencyCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function my($type, CurrencyCreateRequest $request, CurrencyCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            /* Check user trade auth */
            if (in_array('App\Libraries\Traits\Entity\Trade\Auth', class_uses($user)) && $user->isCurrencyUser()) {
                return $response->success($this->repository->focusAccountId($type['type'], $user->trade_account_id));
            }
            throw new ExceptionCode(ExceptionCode::UNAUTHORIZED_OPERATION);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Currency Types
     *
     * Get a list of all currency trade types.
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
     *            "type": "crystal",
     *            "description": "Crystal"
     *        },
     *        {
     *            "type": "gold",
     *            "description": "Gold"
     *        }
     *    ]
     * }
     *
     * @param CurrencyCreateRequest $request
     * @param CurrencyCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function currencyTypes(CurrencyCreateRequest $request, CurrencyCreateResponse $response)
    {
        return $response->success([
            'data' => array_values(app($this->repository->model())->currencyTypes([
                'type',
                'description'
            ]))
        ]);
    }

    /**
     * My Currency Types
     *
     * Get a list of currency trade types held by an account user.
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
     *            "type": "crystal",
     *            "description": "Crystal"
     *        },
     *        {
     *            "type": "gold",
     *            "description": "Gold"
     *        }
     *    ]
     * }
     *
     * @param CurrencyCreateRequest $request
     * @param CurrencyCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myCurrencyTypes(CurrencyCreateRequest $request, CurrencyCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            if (in_array('App\Libraries\Traits\Entity\Trade\Auth', class_uses($user)) && $user->isCurrencyUser()) {
                return $response->success([
                    'data' => array_values($user->heldCurrencyTypes([
                        'type',
                        'description'
                    ]))
                ]);
            }
            throw new ExceptionCode(ExceptionCode::UNAUTHORIZED_OPERATION);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}
