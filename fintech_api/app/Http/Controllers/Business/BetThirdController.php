<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Business\BetThirdCreateRequest;
use App\Http\Requests\Business\BetThirdUpdateRequest;
use App\Http\Responses\Business\BetThirdCreateResponse;
use App\Http\Responses\Business\BetThirdUpdateResponse;
use App\Exceptions\Business\BetThirdExceptionCode as ExceptionCode;
use App\Exceptions\Business\ServiceExceptionCode;
use App\Exceptions\Jwt\AuthExceptionCode;
use App\Libraries\Instances\Router\Janitor;
use App\Libraries\Cells\Service\Business\AuthCell;
use TokenAuth;

/**
 * @group
 *
 * Third Service - Bet
 *
 * @package namespace App\Http\Controllers\Business;
 */
class BetThirdController extends Controller
{
    /**
     * BetThirdController constructor.
     *
     */
    public function __construct()
    {
        /* Check the service status */
        if (! Janitor::isAllowed($this, 'business')) {
            throw new ServiceExceptionCode(ServiceExceptionCode::UNAVAILABLE_SERVICE);
        }
        /* Check the service ip */
        $ip = request()->ip();
        if (count($this->getServiceBindIps()) > 0 && ! in_array($ip, $this->getServiceBindIps())) {
            throw new ServiceExceptionCode(ServiceExceptionCode::UNAUTHORIZED_IP, ['%ip%' => $ip], ['%ip%' => $ip]);
        }
    }

    /**
     * Requester ip restriction list.
     *
     * @return array
     */
    private function getServiceBindIps(): array
    {
        return [
            // You can customize the serviceable IPs
        ];
    }

    /**
     * Get the service data hide keys.
     * 
     * @return array
     */
    public static function getServiceHideKeys(): array
    {
        return [
            'client_id',
            'client_secret',
            'login_cell',
            'login_url',
            'invite_cell',
            'invite_url',
            'invite_ttl',
            // You can customize the service data hiding keys
        ];
    }

    /**
     * Show Member Info
     *
     * Show the member user info.
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
     * nickname | STR | User nickname
     * inviter_uid | STR | Inviter serial id
     * 
     * @urlParam signature required User authorized signature code Example: a0a47a50de0544d49f9a6515a13ae160943d7ddb43bfd2b54da02557f2c09c70042c5a8d
     * 
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "uid": "6281294583",
     *        "nickname": "Player",
     *        "inviter_uid": ""
     *    }
     * }
     *
     * @param  string $signature
     * @param  BetThirdCreateRequest $request
	 * @param  BetThirdCreateResponse $response
	 *
     * @return \Illuminate\Http\Response
     */
    public function profile($signature, BetThirdCreateRequest $request, BetThirdCreateResponse $response)
    {
        /* Get user info */
        $source = AuthCell::input([
            'type' => Janitor::getGuestType($this),
            'signature' => $signature
        ])->run();
        if ($source['success']) {
            return $response->success($source['data']);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Deposit
     *
     * Deposit the specified amount to the user account.
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
     * amount | STR | Amount
     *
     * @bodyParam amount STR required Amount Example: {amount}
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "uid": "6281294583",
     *        "amount": "100"
     *    }
     * }
     *
     * @param  string $amount
     * @param  BetThirdUpdateRequest $request
     * @param  BetThirdUpdateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function deposit(BetThirdUpdateRequest $request, BetThirdUpdateResponse $response)
    {
        if ($user = TokenAuth::getUser()) {

            $amount = $request->input('amount');

            /* Logic function */

            $info = [
                'uid' => $user->uid,
                'amount' => $amount
            ];

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Deduct
     *
     * User account deduct specified amount.
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
     * amount | STR | Amount
     *
     * @bodyParam amount STR required Amount Example: {amount}
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "uid": "6281294583",
     *        "amount": "100"
     *    }
     * }
     *
     * @param  string $amount
     * @param  BetThirdUpdateRequest $request
     * @param  BetThirdUpdateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function deduct(BetThirdUpdateRequest $request, BetThirdUpdateResponse $response)
    {
        if ($user = TokenAuth::getUser()) {

            $amount = $request->input('amount');

            /* Logic function */

            $info = [
                'uid' => $user->uid,
                'amount' => $amount
            ];

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}
