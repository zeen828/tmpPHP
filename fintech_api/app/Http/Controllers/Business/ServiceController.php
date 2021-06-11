<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Business\ServiceCreateRequest;
use App\Http\Requests\Business\ServiceUpdateRequest;
use App\Http\Responses\Business\ServiceCreateResponse;
use App\Http\Responses\Business\ServiceUpdateResponse;
use App\Exceptions\Business\ServiceExceptionCode as ExceptionCode;
use App\Exceptions\Jwt\AuthExceptionCode;
use App\Libraries\Instances\Router\Janitor;
use App\Entities\Member\Auth as Member;
use TokenAuth;
use StorageSignature;

/**
 * @group
 *
 * Business Service
 *
 * @package namespace App\Http\Controllers\Business;
 */
class ServiceController extends Controller
{

    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Service Index
     *
     * Get the service index for the business.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * type | STR | Business type code
     * name | STR | Business service name
     * info | OBJ | Base info items
     *
     * @response
     * {
     *    "success": true,
     *    "data": [
     *        {
     *            "type": "racing",
     *            "name": "Racing Lottery",
     *            "info": {
     *               "banner": "https://www.lottery.com/banner.jpg",
     *               "website": "https://www.lottery.com",
     *               "available_invite": true
     *            }
     *        },
     *        {
     *            "type": "binary",
     *            "name": "Binary Option",
     *            "info": {
     *               "banner": "https://www.binary.com/banner.jpg",
     *               "website": "https://www.binary.com",
     *               "available_invite": false
     *            }
     *        }
     *    ]
     * }
     *
     * @param ServiceCreateRequest $request
     * @param ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        $item = Janitor::getGuests('business');
        $item = collect($item)->map(function ($item, $key) use (&$codes) {
            if (Janitor::isAllowed($item, 'business')) {
                return  [
                    'type' => $key,
                    'name' => Janitor::getGuestName($key),
                    'info' => array_diff_key(Janitor::getGuestData($key), array_flip(Janitor::getGuestClass($key)::getServiceHideKeys()))
                ];
            }
            return null;
        })->reject(function ($item) {
            return empty($item);
        })->all();

        return $response->success(['data' => array_values($item)]);
    }

    /**
     * Auth Link
     *
     * Get the business service auth link.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * link | STR | Authorized signature link
     * expires_in | INT | Authorized signature link valid seconds
     *
     * @bodyParam type STR required Business type code Example: {type}
     * 
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "link": "http://www.example.com/login?signature=8466b336802941ac8df1bd3173bdeb8de1fabcec5fbb036f0c08c550a738b182abab2d07",
     *        "expires_in": 680
     *    }
     * }
     *
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function authLink(ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check user */
        if ($user = TokenAuth::getUser(Member::class)) {
            /* Get business type code */
            $type = $request->input('type');
            /* Check business type */
            if (! Janitor::isAllowed(Janitor::getGuestClass($type), 'business')) {
                throw new ExceptionCode(ExceptionCode::UNAVAILABLE_SERVICE);
            }
            /* Use auth cell */
            if ($class = Janitor::getGuestData($type)['login_cell']) {
                /* Return authorization signature link */
                $source = $class::input([
                    'user' => $user,
                    'type' => $type
                ])->run();
                if ($source['success']) {
                    return $response->success($source['data']);
                }
            }
            throw new ExceptionCode(ExceptionCode::AUTH_LINK_CREATE_FAIL);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Invite Link
     *
     * Create a personal invitation link for business service.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * link | STR | Authorized invitation link
     * expires_in | INT | Authorized invitation link valid seconds
     * 
     * @bodyParam type STR required Business type code Example: {type}
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "link": "http://www.example.com/invite?signature=8466b336802941ac8df1bd3173bdeb8de1fabcec5fbb036f0c08c550a738b182abab2d07",
     *        "expires_in": 680
     *    }
     * }
     *
     * @param  ServiceCreateRequest $request
	 * @param  ServiceCreateResponse $response
	 *
     * @return \Illuminate\Http\Response
     */
    public function inviteLink(ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
         /* Check user */
         if ($user = TokenAuth::getUser(Member::class)) {
            /* Get business type code */
            $type = $request->input('type');
            /* Check business type */
            if (! Janitor::isAllowed(Janitor::getGuestClass($type), 'business')) {
                throw new ExceptionCode(ExceptionCode::UNAVAILABLE_SERVICE);
            }
            /* Use auth cell */
            if ($class = Janitor::getGuestData($type)['invite_cell']) {
                /* Return authorization signature link */
                $source = $class::input([
                    'user' => $user,
                    'type' => $type
                ])->run();
                if ($source['success']) {
                    return $response->success($source['data']);
                }
            }
            throw new ExceptionCode(ExceptionCode::INVITE_LINK_CREATE_FAIL);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Invite Auth
     *
     * User agrees to the invitation and get the business service auth link.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * link | STR | Authorized signature link
     * expires_in | INT | Authorized signature link valid seconds
     * 
     * @bodyParam signature STR required User invitation signature code Example: {signature}
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "link": "http://www.example.com/login?signature=8466b336802941ac8df1bd3173bdeb8de1fabcec5fbb036f0c08c550a738b182abab2d07",
     *        "expires_in": 680
     *    }
     * }
     *
     * @param  ServiceCreateRequest $request
	 * @param  ServiceCreateResponse $response
	 *
     * @return \Illuminate\Http\Response
     */
    public function inviteAuth(ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check user */
        if ($user = TokenAuth::getUser(Member::class)) {
            $signature = $request->input('signature');
            if (($data = StorageSignature::get($signature)) && isset($data['mark'], $data['type'], $data['business'], $data['model'], $data['id']) && $data['mark'] === 'Business' && $data['type'] === 'invite' && $data['model'] === Member::class) {
                StorageSignature::forget($signature);
                /* Get business type code */
                $type = $data['business'];
                /* Check business type */
                if (! Janitor::isAllowed(Janitor::getGuestClass($type), 'business')) {
                    throw new ExceptionCode(ExceptionCode::UNAVAILABLE_SERVICE);
                }
                /* Use auth cell */
                if ($class = Janitor::getGuestData($type)['login_cell']) {
                    /* Return authorization signature link */
                    $source = $class::input([
                        'user' => $user,
                        'inviter' => app($data['model'])->find($data['id']),
                        'type' => $type
                    ])->run();
                    if ($source['success']) {
                        return $response->success($source['data']);
                    }
                }
                throw new ExceptionCode(ExceptionCode::AUTH_LINK_CREATE_FAIL);
            }
            throw new ExceptionCode(ExceptionCode::INVALID_SIGNATURE);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}
