<?php

namespace App\Http\Controllers\Receipt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Receipt\LogCreateRequest;
use App\Http\Requests\Receipt\LogUpdateRequest;
use App\Http\Responses\Receipt\LogCreateResponse;
use App\Http\Responses\Receipt\LogUpdateResponse;
use App\Repositories\Receipt\OperateRepository;
use App\Validators\Receipt\OperateValidator;
use App\Exceptions\Jwt\AuthExceptionCode;
use TokenAuth;

/**
 * @group
 *
 * Receipt Log
 *
 * @package namespace App\Http\Controllers\Receipt;
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
     * Receipt Index
     *
     * Get the receipt index.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Receipt order serial id
     * serial | STR | Receipt self serial id
     * source_id | STR | Receipt source id
     * source | STR | Receipt source type code
     * source_name | STR | Receipt source type name
     * code | INT | Receipt type code
     * form | STR | Receipt form type code
     * form_name | STR | Receipt form type name
     * status | STR | Final attached ststus type of receipt
     * memo.label | STR | Receipt memo label
     * memo.content | STR | Receipt memo content
     * memo.note | STR,ARR,OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
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
     *            "order": "1202010100102",
     *            "serial": "1202010100102",
     *            "source_id": "1294583",
     *            "source": "member",
     *            "source_name": "Member",
     *            "code": 102,
     *            "form": "billing",
     *            "form_name": "Billing Receipt",
     *            "status": "confirm",
     *            "memo": {
     *                "label": "member-store",
     *                "content": "Bill Start",
     *                "note": "Payment,100,TWD"
     *            },
     *            "created_at": "2020-10-10 11:02:21",
     *            "updated_at": "2020-10-10 11:02:21"
     *        },
     *        {
     *            "order": "1202010100102",
     *            "serial": "2202010100301",
     *            "source_id": "1294583",
     *            "source": "system",
     *            "source_name": "System",
     *            "code": 301,
     *            "form": "confirm",
     *            "form_name": "Confirm Receipt",
     *            "status": "confirm",
     *            "memo": {
     *                "label": "system-verify",
     *                "content": "Confirm Bill",
     *                "note": "Receive,100,TWD"
     *            },
     *            "created_at": "2020-10-10 11:02:21",
     *            "updated_at": "2020-10-10 11:02:21"
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
     * Order Info
     *
     * Get the receipt order info.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Receipt order serial id
     * serial | STR | Receipt self serial id
     * source_id | STR | Receipt source id
     * source | STR | Receipt source type code
     * source_name | STR | Receipt source type name
     * code | INT | Receipt type code
     * form | STR | Receipt form type code
     * form_name | STR | Receipt form type name
     * status | STR | Final attached ststus type of receipt
     * memo.label | STR | Receipt memo label
     * memo.content | STR | Receipt memo content
     * memo.note | STR,ARR,OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @urlParam order required Receipt order serial id Example: 1202010100102
     *
     * @response
     * {
     *    "success": true,
     *    "data": [
     *        {
     *            "order": "1202010100102",
     *            "serial": "1202010100102",
     *            "source_id": "1294583",
     *            "source": "member",
     *            "source_name": "Member",
     *            "code": 102,
     *            "form": "billing",
     *            "form_name": "Billing Receipt",
     *            "status": "confirm",
     *            "memo": {
     *                "label": "member-store",
     *                "content": "Bill Start",
     *                "note": "Payment,100,TWD"
     *            },
     *            "created_at": "2020-10-10 11:02:21",
     *            "updated_at": "2020-10-10 11:02:21"
     *        },
     *        {
     *            "order": "1202010100102",
     *            "serial": "2202010100301",
     *            "source_id": "1294583",
     *            "source": "system",
     *            "source_name": "System",
     *            "code": 301,
     *            "form": "confirm",
     *            "form_name": "Confirm Receipt",
     *            "status": "confirm",
     *            "memo": {
     *                "label": "system-verify",
     *                "content": "Confirm Bill",
     *                "note": "Receive,100,TWD"
     *            },
     *            "created_at": "2020-10-10 11:02:21",
     *            "updated_at": "2020-10-10 11:02:21"
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
     * Order Main Info
     *
     * Get the receipt order master serial info.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Receipt order serial id
     * serial | STR | Receipt self serial id
     * source_id | STR | Receipt source id
     * source | STR | Receipt source type code
     * source_name | STR | Receipt source type name
     * code | INT | Receipt type code
     * form | STR | Receipt form type code
     * form_name | STR | Receipt form type name
     * status | STR | Final attached ststus type of receipt
     * memo.label | STR | Receipt memo label
     * memo.content | STR | Receipt memo content
     * memo.note | STR,ARR,OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @urlParam order required Receipt order serial id Example: 1202010100102
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "1202010100102",
     *       "serial": "1202010100102",
     *       "source_id": "1294583",
     *       "source": "member",
     *       "source_name": "Member",
     *       "code": 102,
     *       "form": "billing",
     *       "form_name": "Billing Receipt",
     *       "status": "confirm",
     *       "memo": {
     *           "label": "member-store",
     *           "content": "Bill Start",
     *           "note": "Payment,100,TWD"
     *       },
     *       "created_at": "2020-10-10 11:02:21",
     *       "updated_at": "2020-10-10 11:02:21"
     *    }
     * }
     *
     * @param string $order
     * @param LogCreateRequest $request
     * @param LogCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function readMain($order, LogCreateRequest $request, LogCreateResponse $response)
    {
        $order = $this->repository->pickOrderMainSerial($order);
        /* Transformer */
        $transformer = app($this->repository->presenter())->getTransformer();
        /* Array Info */
        $info = $transformer->transform($order);
        
        return $response->success($info);
    }

    /**
     * Order Last Info
     *
     * Get the receipt order last serial info.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Receipt order serial id
     * serial | STR | Receipt self serial id
     * source_id | STR | Receipt source id
     * source | STR | Receipt source type code
     * source_name | STR | Receipt source type name
     * code | INT | Receipt type code
     * form | STR | Receipt form type code
     * form_name | STR | Receipt form type name
     * status | STR | Final attached ststus type of receipt
     * memo.label | STR | Receipt memo label
     * memo.content | STR | Receipt memo content
     * memo.note | STR,ARR,OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @urlParam order required Receipt order serial id Example: 1202010100102
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "1202010100102",
     *       "serial": "2202010100301",
     *       "source_id": "1294583",
     *       "source": "system",
     *       "source_name": "System",
     *       "code": 301,
     *       "form": "confirm",
     *       "form_name": "Confirm Receipt",
     *       "status": "confirm",
     *       "memo": {
     *           "label": "system-verify",
     *           "content": "Confirm Bill",
     *           "note": "Receive,100,TWD"
     *       },
     *       "created_at": "2020-10-10 11:02:21",
     *       "updated_at": "2020-10-10 11:02:21"
     *    }
     * }
     *
     * @param string $order
     * @param LogCreateRequest $request
     * @param LogCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function readLast($order, LogCreateRequest $request, LogCreateResponse $response)
    {
        $order = $this->repository->pickOrderLastSerial($order);
        /* Transformer */
        $transformer = app($this->repository->presenter())->getTransformer();
        /* Array Info */
        $info = $transformer->transform($order);
        
        return $response->success($info);
    }

    /**
     * My Form Receipt Index
     *
     * Get the edited info of the user's receipt index.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Receipt order serial id
     * serial | STR | Receipt self serial id
     * source_id | STR | Receipt source id
     * source | STR | Receipt source type code
     * source_name | STR | Receipt source type name
     * code | INT | Receipt type code
     * form | STR | Receipt form type code
     * form_name | STR | Receipt form type name
     * status | STR | Final attached ststus type of receipt
     * memo.label | STR | Receipt memo label
     * memo.content | STR | Receipt memo content
     * memo.note | STR,ARR,OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
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
     *            "order": "1202010100102",
     *            "serial": "1202010100102",
     *            "source_id": "1294583",
     *            "source": "member",
     *            "source_name": "Member",
     *            "code": 102,
     *            "form": "billing",
     *            "form_name": "Billing Receipt",
     *            "status": "confirm",
     *            "memo": {
     *                "label": "member-store",
     *                "content": "Bill Start",
     *                "note": "Payment,100,TWD"
     *            },
     *            "created_at": "2020-10-10 11:02:21",
     *            "updated_at": "2020-10-10 11:02:21"
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
            $perPage = $request->input('rows', 15);
            return $response->success($this->repository->index($perPage, $user));
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * My Form Order Info
     *
     * Get the edited info of the user's order.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Receipt order serial id
     * serial | STR | Receipt self serial id
     * source_id | STR | Receipt source id
     * source | STR | Receipt source type code
     * source_name | STR | Receipt source type name
     * code | INT | Receipt type code
     * form | STR | Receipt form type code
     * form_name | STR | Receipt form type name
     * status | STR | Final attached ststus type of receipt
     * memo.label | STR | Receipt memo label
     * memo.content | STR | Receipt memo content
     * memo.note | STR,ARR,OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @urlParam order required Receipt order serial id Example: 1202010100102
     *
     * @response
     * {
     *    "success": true,
     *    "data": [
     *        {
     *            "order": "1202010100102",
     *            "serial": "1202010100102",
     *            "source_id": "1294583",
     *            "source": "member",
     *            "source_name": "Member",
     *            "code": 102,
     *            "form": "billing",
     *            "form_name": "Billing Receipt",
     *            "status": "confirm",
     *            "memo": {
     *                "label": "member-store",
     *                "content": "Bill Start",
     *                "note": "Payment,100,TWD"
     *            },
     *            "created_at": "2020-10-10 11:02:21",
     *            "updated_at": "2020-10-10 11:02:21"
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
            return $response->success($this->repository->focusOrder($order, $user));
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * My Order Main Info
     *
     * Get the user's receipt order master serial info.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Receipt order serial id
     * serial | STR | Receipt self serial id
     * source_id | STR | Receipt source id
     * source | STR | Receipt source type code
     * source_name | STR | Receipt source type name
     * code | INT | Receipt type code
     * form | STR | Receipt form type code
     * form_name | STR | Receipt form type name
     * status | STR | Final attached ststus type of receipt
     * memo.label | STR | Receipt memo label
     * memo.content | STR | Receipt memo content
     * memo.note | STR,ARR,OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @urlParam order required Receipt order serial id Example: 1202010100102
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "1202010100102",
     *       "serial": "1202010100102",
     *       "source_id": "1294583",
     *       "source": "member",
     *       "source_name": "Member",
     *       "code": 102,
     *       "form": "billing",
     *       "form_name": "Billing Receipt",
     *       "status": "confirm",
     *       "memo": {
     *           "label": "member-store",
     *           "content": "Bill Start",
     *           "note": "Payment,100,TWD"
     *       },
     *       "created_at": "2020-10-10 11:02:21",
     *       "updated_at": "2020-10-10 11:02:21"
     *    }
     * }
     *
     * @param string $order
     * @param LogCreateRequest $request
     * @param LogCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myOrderMain($order, LogCreateRequest $request, LogCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {

            $order = $this->repository->pickOrderMainSerial($order, $user);
            /* Transformer */
            $transformer = app($this->repository->presenter())->getTransformer();
            /* Array Info */
            $info = $transformer->transform($order);
            
            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * My Order Last Info
     *
     * Get the user's receipt order last serial info.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * order | STR | Receipt order serial id
     * serial | STR | Receipt self serial id
     * source_id | STR | Receipt source id
     * source | STR | Receipt source type code
     * source_name | STR | Receipt source type name
     * code | INT | Receipt type code
     * form | STR | Receipt form type code
     * form_name | STR | Receipt form type name
     * status | STR | Final attached ststus type of receipt
     * memo.label | STR | Receipt memo label
     * memo.content | STR | Receipt memo content
     * memo.note | STR,ARR,OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @urlParam order required Receipt order serial id Example: 1202010100102
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "1202010100102",
     *       "serial": "2202010100301",
     *       "source_id": "1294583",
     *       "source": "system",
     *       "source_name": "System",
     *       "code": 301,
     *       "form": "confirm",
     *       "form_name": "Confirm Receipt",
     *       "status": "confirm",
     *       "memo": {
     *           "label": "system-verify",
     *           "content": "Confirm Bill",
     *           "note": "Receive,100,TWD"
     *       },
     *       "created_at": "2020-10-10 11:02:21",
     *       "updated_at": "2020-10-10 11:02:21"
     *    }
     * }
     *
     * @param string $order
     * @param LogCreateRequest $request
     * @param LogCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myOrderLast($order, LogCreateRequest $request, LogCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            $order = $this->repository->pickOrderLastSerial($order, $user);
            /* Transformer */
            $transformer = app($this->repository->presenter())->getTransformer();
            /* Array Info */
            $info = $transformer->transform($order);
            
            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}