<?php

namespace App\Http\Controllers\Trade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Trade\LogCreateRequest;
use App\Http\Requests\Trade\LogUpdateRequest;
use App\Http\Responses\Trade\LogCreateResponse;
use App\Http\Responses\Trade\LogUpdateResponse;
use App\Exceptions\Trade\OperateExceptionCode as ExceptionCode;
use App\Repositories\Trade\OperateRepository;
use App\Validators\Trade\OperateValidator;
use App\Exceptions\Jwt\AuthExceptionCode;
use TokenAuth;

/**
 * @group
 *
 * Trade Log
 *
 * @package namespace App\Http\Controllers\Trade;
 */
class LogController extends Controller
{
    /**
     * @var OperateRepository
     */
    protected $repository;

    /**
     * @var OperateValidator
     */
    protected $validator;

    /**
     * LogController constructor.
     *
     * @param OperateRepository $repository
     * @param OperateValidator $validator
     */
    public function __construct(OperateRepository $repository, OperateValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Trade Index
     *
     * Get all trade log index.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Trade order serial id
     * serial | STR | Trade self serial id
     * account | STR | Currency account serial id
     * currency | STR | Trade currency type code
     * currency_name | STR | Trade currency type name
     * source_id | STR | Trade source id
     * source | STR | Trade source type code
     * source_name | STR | Trade source type name
     * operate | STR | Trade operate type ( expenses, income )
     * amount | STR | Trade amount
     * balance | STR | Total account balance
     * code | INT | Trade type code
     * memo.label | STR | Trade memo label
     * memo.content | STR | Trade memo content
     * memo.note | STR,ARR,OBJ | Trade memo note
     * created_at | STR | Datetime when the trade was created
     * updated_at | STR | Datetime when the trade was updated
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
     *            "order": "101022020041526",
     *            "serial": "101022020041526",
     *            "account": "100022058",
     *            "currency": "crystal",
     *            "currency_name": "Crystal",
     *            "source_id": "3515611",
     *            "source": "member",
     *            "source_name": "Member",
     *            "operate": "expenses",
     *            "amount": "35",
     *            "balance": "65",
     *            "code": "10102",
     *            "memo": {
     *                  "label": "member-trade",
     *                  "content": "Purchase Expenditure",
     *                  "note": "Rice Ball"
     *            },
     *            "created_at": "2020-04-15 14:02:47",
     *            "updated_at": "2020-04-15 14:02:47"
     *        },
     *        {
     *            "order": "101022020041526",
     *            "serial": "201022020041527",
     *            "account": "300830084",
     *            "currency": "crystal",
     *            "currency_name": "Crystal",
     *            "source_id": "1294583",
     *            "source": "member",
     *            "source_name": "Member",
     *            "operate": "income",
     *            "amount": "35",
     *            "balance": "35",
     *            "code": "20102",
     *            "memo": {
     *                  "label": "member-trade",
     *                  "content": "Member Consumption",
     *                  "note": "Rice Ball"
     *            },
     *            "created_at": "2020-04-15 14:02:47",
     *            "updated_at": "2020-04-15 14:02:47"
     *        }
     *    ],
     *    "meta": {
     *        "pagination": {
     *            "total": 2,
     *            "count": 2,
     *            "per_page": 15,
     *            "current_page": 1,
     *            "total_pages": 1
     *        }
     *    }
     * }
     *
     * @param LogCreateRequest $request
     * @param LogCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LogCreateRequest $request, LogCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);
        return $response->success($this->repository->index($perPage));
    }

    /**
     * Currency Trade Index
     *
     * Get all trade log index of currency type.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Trade order serial id
     * serial | STR | Trade self serial id
     * account | STR | Currency account serial id
     * currency | STR | Trade currency type code
     * currency_name | STR | Trade currency type name
     * source_id | STR | Trade source id
     * source | STR | Trade source type code
     * source_name | STR | Trade source type name
     * operate | STR | Trade operate type ( expenses, income )
     * amount | STR | Trade amount
     * balance | STR | Total account balance
     * code | INT | Trade type code
     * memo.label | STR | Trade memo label
     * memo.content | STR | Trade memo content
     * memo.note | STR,ARR,OBJ | Trade memo note
     * created_at | STR | Datetime when the trade was created
     * updated_at | STR | Datetime when the trade was updated
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
     *            "order": "101022020041526",
     *            "serial": "101022020041526",
     *            "account": "100022058",
     *            "currency": "crystal",
     *            "currency_name": "Crystal",
     *            "source_id": "3515611",
     *            "source": "member",
     *            "source_name": "Member",
     *            "operate": "expenses",
     *            "amount": "35",
     *            "balance": "65",
     *            "code": "10102",
     *            "memo": {
     *                  "label": "member-trade",
     *                  "content": "Purchase Expenditure",
     *                  "note": "Rice Ball"
     *            },
     *            "created_at": "2020-04-15 14:02:47",
     *            "updated_at": "2020-04-15 14:02:47"
     *        },
     *        {
     *            "order": "101022020041526",
     *            "serial": "201022020041527",
     *            "account": "300830084",
     *            "currency": "crystal",
     *            "currency_name": "Crystal",
     *            "source_id": "1294583",
     *            "source": "member",
     *            "source_name": "Member",
     *            "operate": "income",
     *            "amount": "35",
     *            "balance": "35",
     *            "code": "20102",
     *            "memo": {
     *                  "label": "member-trade",
     *                  "content": "Member Consumption",
     *                  "note": "Rice Ball"
     *            },
     *            "created_at": "2020-04-15 14:02:47",
     *            "updated_at": "2020-04-15 14:02:47"
     *        }
     *    ],
     *    "meta": {
     *        "pagination": {
     *            "total": 2,
     *            "count": 2,
     *            "per_page": 15,
     *            "current_page": 1,
     *            "total_pages": 1
     *        }
     *    }
     * }
     *
     * @param array $type
     * @param LogCreateRequest $request
     * @param LogCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function currencyIndex($type, LogCreateRequest $request, LogCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);
        return $response->success($this->repository->index($perPage, $type['type']));
    }
    
    /**
     * Order Info
     *
     * Get the trade order info.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Trade order serial id
     * serial | STR | Trade self serial id
     * account | STR | Currency account serial id
     * currency | STR | Trade currency type code
     * currency_name | STR | Trade currency type name
     * source_id | STR | Trade source id
     * source | STR | Trade source type code
     * source_name | STR | Trade source type name
     * operate | STR | Trade operate type ( expenses, income )
     * amount | STR | Trade amount
     * balance | STR | Total account balance
     * code | INT | Trade type code
     * memo.label | STR | Trade memo label
     * memo.content | STR | Trade memo content
     * memo.note | STR,ARR,OBJ | Trade memo note
     * created_at | STR | Datetime when the trade was created
     * updated_at | STR | Datetime when the trade was updated
     *
     * @urlParam order required Trade order serial id Example: 101022020041526
     * 
     * @response
     * {
     *    "success": true,
     *    "data": [
     *        {
     *            "order": "101022020041526",
     *            "serial": "101022020041526",
     *            "account": "100022058",
     *            "currency": "crystal",
     *            "currency_name": "Crystal",
     *            "source_id": "3515611",
     *            "source": "member",
     *            "source_name": "Member",
     *            "operate": "expenses",
     *            "amount": "35",
     *            "balance": "65",
     *            "code": "10102",
     *            "memo": {
     *                  "label": "member-trade",
     *                  "content": "Purchase Expenditure",
     *                  "note": "Rice Ball"
     *            },
     *            "created_at": "2020-04-15 14:02:47",
     *            "updated_at": "2020-04-15 14:02:47"
     *        },
     *        {
     *            "order": "101022020041526",
     *            "serial": "201022020041527",
     *            "account": "300830084",
     *            "currency": "crystal",
     *            "currency_name": "Crystal",
     *            "source_id": "1294583",
     *            "source": "member",
     *            "source_name": "Member",
     *            "operate": "income",
     *            "amount": "35",
     *            "balance": "35",
     *            "code": "20102",
     *            "memo": {
     *                  "label": "member-trade",
     *                  "content": "Member Consumption",
     *                  "note": "Rice Ball"
     *            },
     *            "created_at": "2020-04-15 14:02:47",
     *            "updated_at": "2020-04-15 14:02:47"
     *        }
     *    ]
     * }
     *
     * @param string $order
     * @param LogCreateRequest $request
     * @param LogCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function read($order, LogCreateRequest $request, LogCreateResponse $response)
    {
        return $response->success($this->repository->focusOrder($order));
    }

    /**
     * My Trade Index
     *
     * Get the user's trade log index.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Trade order serial id
     * serial | STR | Trade self serial id
     * account | STR | Currency account serial id
     * currency | STR | Trade currency type code
     * currency_name | STR | Trade currency type name
     * source_id | STR | Trade source id
     * source | STR | Trade source type code
     * source_name | STR | Trade source type name
     * operate | STR | Trade operate type ( expenses, income )
     * amount | STR | Trade amount
     * balance | STR | Total account balance
     * code | INT | Trade type code
     * memo.label | STR | Trade memo label
     * memo.content | STR | Trade memo content
     * memo.note | STR,ARR,OBJ | Trade memo note
     * created_at | STR | Datetime when the trade was created
     * updated_at | STR | Datetime when the trade was updated
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
     *            "order": "101022020041526",
     *            "serial": "101022020041526",
     *            "account": "100022058",
     *            "currency": "crystal",
     *            "currency_name": "Crystal",
     *            "source_id": "3515611",
     *            "source": "member",
     *            "source_name": "Member",
     *            "operate": "expenses",
     *            "amount": "35",
     *            "balance": "65",
     *            "code": "10102",
     *            "memo": {
     *                  "label": "member-trade",
     *                  "content": "Purchase Expenditure",
     *                  "note": "Rice Ball"
     *            },
     *            "created_at": "2020-04-15 14:02:47",
     *            "updated_at": "2020-04-15 14:02:47"
     *        }
     *    ],
     *    "meta": {
     *        "pagination": {
     *            "total": 1,
     *            "count": 1,
     *            "per_page": 15,
     *            "current_page": 1,
     *            "total_pages": 1
     *        }
     *    }
     * }
     *
     * @param LogCreateRequest $request
     * @param LogCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function my(LogCreateRequest $request, LogCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            /* Check user trade auth */
            if (in_array('App\Libraries\Traits\Entity\Trade\Auth', class_uses($user)) && $user->isCurrencyUser()) {
                $perPage = $request->input('rows', 15);
                return $response->success($this->repository->index($perPage, null, $user));
            }
            throw new ExceptionCode(ExceptionCode::UNAUTHORIZED_OPERATION);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * My Currency Trade Index
     *
     * Get the user's currency trade log index.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Trade order serial id
     * serial | STR | Trade self serial id
     * account | STR | Currency account serial id
     * currency | STR | Trade currency type code
     * currency_name | STR | Trade currency type name
     * source_id | STR | Trade source id
     * source | STR | Trade source type code
     * source_name | STR | Trade source type name
     * operate | STR | Trade operate type ( expenses, income )
     * amount | STR | Trade amount
     * balance | STR | Total account balance
     * code | INT | Trade type code
     * memo.label | STR | Trade memo label
     * memo.content | STR | Trade memo content
     * memo.note | STR,ARR,OBJ | Trade memo note
     * created_at | STR | Datetime when the trade was created
     * updated_at | STR | Datetime when the trade was updated
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
     *            "order": "101022020041526",
     *            "serial": "101022020041526",
     *            "account": "100022058",
     *            "currency": "crystal",
     *            "currency_name": "Crystal",
     *            "source_id": "3515611",
     *            "source": "member",
     *            "source_name": "Member",
     *            "operate": "expenses",
     *            "amount": "35",
     *            "balance": "65",
     *            "code": "10102",
     *            "memo": {
     *                  "label": "member-trade",
     *                  "content": "Purchase Expenditure",
     *                  "note": "Rice Ball"
     *            },
     *            "created_at": "2020-04-15 14:02:47",
     *            "updated_at": "2020-04-15 14:02:47"
     *        }
     *    ],
     *    "meta": {
     *        "pagination": {
     *            "total": 1,
     *            "count": 1,
     *            "per_page": 15,
     *            "current_page": 1,
     *            "total_pages": 1
     *        }
     *    }
     * }
     *
     * @param array $type
     * @param LogCreateRequest $request
     * @param LogCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function currencyMy($type, LogCreateRequest $request, LogCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            /* Check user trade auth */
            if (in_array('App\Libraries\Traits\Entity\Trade\Auth', class_uses($user)) && $user->isCurrencyUser()) {
                $perPage = $request->input('rows', 15);
                return $response->success($this->repository->index($perPage, $type['type'], $user));
            }
            throw new ExceptionCode(ExceptionCode::UNAUTHORIZED_OPERATION);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * My Order Info
     *
     * Get the user's trade order info.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Trade order serial id
     * serial | STR | Trade self serial id
     * account | STR | Currency account serial id
     * currency | STR | Trade currency type code
     * currency_name | STR | Trade currency type name
     * source_id | STR | Trade source id
     * source | STR | Trade source type code
     * source_name | STR | Trade source type name
     * operate | STR | Trade operate type ( expenses, income )
     * amount | STR | Trade amount
     * balance | STR | Total account balance
     * code | INT | Trade type code
     * memo.label | STR | Trade memo label
     * memo.content | STR | Trade memo content
     * memo.note | STR,ARR,OBJ | Trade memo note
     * created_at | STR | Datetime when the trade was created
     * updated_at | STR | Datetime when the trade was updated
     *
     * @urlParam order required Trade order serial id Example: 101022020041526
     * 
     * @response
     * {
     *    "success": true,
     *    "data": [
     *        {
     *            "order": "101022020041526",
     *            "serial": "101022020041526",
     *            "account": "100022058",
     *            "currency": "crystal",
     *            "currency_name": "Crystal",
     *            "source_id": "3515611",
     *            "source": "member",
     *            "source_name": "Member",
     *            "operate": "expenses",
     *            "amount": "35",
     *            "balance": "65",
     *            "code": "10102",
     *            "memo": {
     *                  "label": "member-trade",
     *                  "content": "Purchase Expenditure",
     *                  "note": "Rice Ball"
     *            },
     *            "created_at": "2020-04-15 14:02:47",
     *            "updated_at": "2020-04-15 14:02:47"
     *        }
     *    ]
     * }
     *
     * @param string $order
     * @param LogCreateRequest $request
     * @param LogCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myOrder($order, LogCreateRequest $request, LogCreateResponse $response)
    {
         /* Check token guard */
         if ($user = TokenAuth::getUser()) {
            /* Check user trade auth */
            if (in_array('App\Libraries\Traits\Entity\Trade\Auth', class_uses($user)) && $user->isCurrencyUser()) {
                return $response->success($this->repository->focusOrder($order, $user));
            }
            throw new ExceptionCode(ExceptionCode::UNAUTHORIZED_OPERATION);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}