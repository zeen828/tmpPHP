<?php

namespace App\Http\Controllers\Receipt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Receipt\FormCreateRequest;
use App\Http\Requests\Receipt\FormUpdateRequest;
use App\Http\Responses\Receipt\FormCreateResponse;
use App\Http\Responses\Receipt\FormUpdateResponse;
use App\Exceptions\Receipt\OperateExceptionCode as ExceptionCode;
use App\Repositories\Receipt\FormRepository;
use App\Validators\Receipt\FormValidator;
use App\Exceptions\Jwt\AuthExceptionCode;
use TokenAuth;

/**
 * @group
 *
 * Receipt Form
 *
 * @package namespace App\Http\Controllers\Receipt;
 */
class FormController extends Controller
{
    /**
     * @var FormRepository
     */
    protected $repository;

    /**
     * @var FormValidator
     */
    protected $validator;

    /**
     * FormController constructor.
     *
     * @param FormRepository $repository
     * @param FormValidator $validator
     */
    public function __construct(FormRepository $repository, FormValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Form Data Index
     *
     * Get the form data index.
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
     * @urlParam type required Receipt form type code Example: billing
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
     *            "form_name": "Billing",
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
     * @param string $type
     * @param FormCreateRequest $request
     * @param FormCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($type, FormCreateRequest $request, FormCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);
        return $response->success($this->repository->index($type, $perPage));
    }

    /**
     * My Form Data
     *
     * Get the user's form data list.
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
     * @urlParam type required Receipt form type code Example: billing
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
     *            "form_name": "Billing",
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
     * @param string $type
     * @param FormCreateRequest $request
     * @param FormCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function my($type, FormCreateRequest $request, FormCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            $perPage = $request->input('rows', 15);
            return $response->success($this->repository->index($type, $perPage, $user));
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Form Types
     *
     * Get a list of all form receipt types.
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
     *            "type": "billing",
     *            "description": "Billing"
     *        },
     *        {
     *            "type": "confirm",
     *            "description": "Confirm"
     *        }
     *    ]
     * }
     *
     * @param FormCreateRequest $request
     * @param FormCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function formTypes(FormCreateRequest $request, FormCreateResponse $response)
    {
        return $response->success([
            'data' => array_values(app($this->repository->model())->formTypes([
                'type',
                'description'
            ]))
        ]);
    }

    /**
     * My Form Types
     *
     * Get a list of form receipt types held by an user.
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
     *            "type": "billing",
     *            "description": "Billing"
     *        }
     *    ]
     * }
     *
     * @param FormCreateRequest $request
     * @param FormCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myFormTypes(FormCreateRequest $request, FormCreateResponse $response)
    {
        /* Check token guard */
        if ($user = TokenAuth::getUser()) {
            if (in_array('App\Libraries\Traits\Entity\Receipt\Auth', class_uses($user)) && $user->isFormUser()) {
                $source = [
                    'data' => array_values($user->heldFormTypes([
                        'type',
                        'description'
                    ]))
                ];
            } else {
                $source = [
                    'data' => []
                ];
            }
            return $response->success($source);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}