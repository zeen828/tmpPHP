<?php

namespace App\Http\Controllers\ThirdService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Requests，Responses，Exceptions
use App\Http\Requests\ThirdService\FintechRequest;
use App\Http\Responses\ThirdService\FintechResponse;
use App\Exceptions\ThirdService\FintechExceptionCode as ExceptionCode;
// DB
use App\Repositories\Member\UserRepository;
use App\Validators\Member\UserValidator;
// lib
use App\Libraries\Docking\Auth as DockingAuth;
use TokenAuth;
// 交易
use StorageSignature;
use App\Entities\Jwt\Auth;
use App\Entities\Member\Auth as MemberAuth;
use App\Entities\Account\Gold;
use DB;

/**
 * @group
 * 
 * Docking / Third Service
 * 
 * @package namespace App\Http\Controllers\ThirdService;
 */
class FintechController extends Controller
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
     * User login signature
     * 
     * Docking third service user login signature。
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
     * @param FintechRequest $request
     * @param FintechResponse $response
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function signatureLogin(FintechRequest $request, FintechResponse $response)
    {
        /* Register */
        $credentials = $request->only([
            'signature',
            'uid',
            'debug',
        ]);

        // 對接
        $docking = new DockingAuth();
        if (isset($credentials['debug']) && $credentials['debug'] == 8) {
            $docking->debug();
        } elseif(isset($credentials['debug']) && $credentials['debug'] == 7) {
            return $response->success(['msg'=>'除錯編號7測試回傳']);
        }
        $docking->thirdAuth($credentials['signature']);

        // 取要的值
        $account = $docking->getUserUid();
        $accessToken = '';

        /* source */
        $client = TokenAuth::getClient();
        $sourceType = get_class($client);
        $sourceId = $client->id;

        $parent_id = 0;
        if (!empty($credentials['uid'])) {
            $father_user = $this->repository->loginRegister($sourceType, $sourceId, $credentials['uid'], '', '0');
            $parent_id = $father_user->id;
        }
        /* login member user or register new member user */
        $user = $this->repository->loginRegister($sourceType, $sourceId, $account, $accessToken, $parent_id);

        if ($token = TokenAuth::loginUser($user)) {
            $source = [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $user->getTTL() * 60
            ];
            return $response->success($source);
        }
        throw new ExceptionCode(ExceptionCode::USER_AUTH_FAIL);
    }

    // 對接接收訂單，接收請求
    public function pointImport(FintechRequest $request, FintechResponse $response)
    {
        /* Register */
        $credentials = $request->only([
            'signature',
            'amount',
            'receipt',
            'debug',
        ]);

        // // 對接
        // $docking = new DockingAuth();
        // if ($credentials['debug'] == 8) {
        //     $docking->debug();
        // }
        // $docking->authClient()->authUserSignature($credentials['signature'])->readUser();

        // // 取要的值
        // $account = $docking->getUserUid();
        // $accessToken = $docking->getUserToken();

        /* source */
        $client = TokenAuth::getClient();
        $sourceType = get_class($client);
        $sourceId = $client->id;
        print_r($client);

        $user = TokenAuth::getUser();
        print_r($user);

        // exit();

        // 轉換成會員
        // $user = $this->repository->loginRegister($sourceType, $sourceId, $account, $accessToken, 0);

        // 加點
        $account = $user->tradeAccount(Gold::class);
        // var_dump($account);
        $amount = $account->amount;
        // print_r($amount);
        // exit();
        // DB Transaction begin
        DB::beginTransaction();
        $item = $account->where('id', $account->id)->lockForUpdate()->first();
        $trade = $item->beginTradeAmount($client);
        // Amount of income by trade
        $order = $trade->amountOfIncome($credentials['amount'], [
            'label' => 'Docking Member Point Input',
            'content' => 'INCOME',
            'note' => array(
                'post' => $credentials
            )
        ]);
        // print_r($order);
        // echo "頂單: \n";
        // print_r($order->order);
        // echo "簽章: 跟訂單一樣 \n";
        // print_r($order->serial);

        // 單據
        $receipt = $user->submitReceipt('deposit', [
            'label' => 'Docking Member Point Input',
            'content' => 'Docking Member Point Input.',
            'note' => [
                // 交易訂單號碼
                'tradeOrder' => $order->order,
            ],
        ]);
        // Synchronization update main $order status field
        DB::commit($receipt);

        return $response->success([
            'title' => '接收單據',
            'receipt' => $receipt->order,
        ]);
    }

    // 對接發起訂單，發起請求
    public function pointExport(FintechRequest $request, FintechResponse $response)
    {
        /* Register */
        $credentials = $request->only([
            'amount',
            'debug',
        ]);

        $client = TokenAuth::getClient();
        // var_dump($client);
        $user = TokenAuth::getUser();
        // var_dump($user);
        
        // 扣點
        $account = $user->tradeAccount(Gold::class);
        // var_dump($account);
        $amount = $account->amount;
        // print_r($amount);
        // exit();
        // DB Transaction begin
        DB::beginTransaction();
        $item = $account->where('id', $account->id)->lockForUpdate()->first();
        $trade = $item->beginTradeAmount($client);
        // Amount of income by trade
        $order = $trade->amountOfExpenses($credentials['amount'], [
            'label' => 'Docking Member Point Output',
            'content' => 'EXPENSES',
            'note' => array(
                'post' => $credentials
            )
        ]);
        // print_r($order);
        // echo "頂單: \n";
        // print_r($order->order);
        // echo "簽章: 跟訂單一樣 \n";
        // print_r($order->serial);

        // 單據
        $receipt = $user->submitReceipt('deposit', [
            'label' => 'Docking Member Point Output',
            'content' => 'Docking Member Point Output.',
            'note' => [
                // 交易訂單號碼
                'tradeOrder' => $order->order,
            ],
        ]);
        // Synchronization update main $order status field
        DB::commit($receipt);

        // 簽章
        $ttl = 5;
        $data = [
            'userUid' => $user->uid,
            'amount' => $credentials['amount'],
            'receipt' => $receipt->order,
        ];
        $code = StorageSignature::build($data, $ttl);

        return $response->success([
            'title' => '發起單據',
            'receipt' => $receipt->order,
            'signature' => $code,
        ]);
    }
}
