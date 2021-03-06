<?php

namespace App\Http\Controllers\Exchange;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Exchange\PaydayThirdCreateRequest;
use App\Http\Requests\Exchange\PaydayThirdUpdateRequest;
use App\Http\Responses\Exchange\PaydayThirdCreateResponse;
use App\Http\Responses\Exchange\PaydayThirdUpdateResponse;
use App\Exceptions\Exchange\PaydayThirdExceptionCode as ExceptionCode;
use App\Exceptions\Exchange\ServiceExceptionCode;
use App\Libraries\Instances\Router\Janitor;
use App\Repositories\Receipt\OperateRepository;
use TokenAuth;
use Carbon;
use StorageSignature;
use Cache;
use Validator;
use DB;
use App\Entities\Member\Auth;
use App\Entities\Account\Gold;
use App\Libraries\Cells\Service\Payday\Billing\StoreCell as StoreBilling;
use App\Libraries\Cells\Service\Payday\Billing\AtmCell as AtmBilling;
use App\Libraries\Cells\Service\Payday\Billing\CreditCell as CreditBilling;
use App\Libraries\Cells\Service\Payday\Billing\TransferCell as TransferBilling;

/**
 * @group
 *
 * Third Service - Payday
 *
 * @package namespace App\Http\Controllers\Exchange;
 */
class PaydayThirdController extends Controller
{
    /**
     * @var OperateRepository
     */
    protected $repository;

    /**
     * PaydayThirdController constructor.
     *
     * @param OperateRepository $repository
     */
    public function __construct(OperateRepository $repository)
    {
        $this->repository = $repository;
        /* Check the service */
        if (! Janitor::isAllowed($this, 'exchange')) {
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
     * Billing Page
     *
     * Use payment authorization to the transaction page.
     *
     * ### Response HTML Page
     *
     * @param  string $code
     * @param  PaydayThirdCreateRequest $code
     * @param  PaydayThirdCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function billing($code ,PaydayThirdCreateRequest $request, PaydayThirdCreateResponse $response)
    {
        /** Auth code */
        $data = StorageSignature::get($code);
        /* Check signature user */
        if (isset($data['client'], $data['app_id'], $data['model'], $data['id'], $data['amount'], $data['type']) && TokenAuth::model() !== $data['model'] && ($guard = TokenAuth::getAuthGuard($data['model'])) && $guard === TokenAuth::getAuthGuard(Auth::class)) {
            /* Cache forget */
            StorageSignature::forget($code);
            /* Get the billing type */
            $type = $data['type'];
            /* Get the billingables */
            $billingables = config('exchange.billingables');
            /* Check billing type */
            if (! isset($billingables[$type])) {
                throw new ExceptionCode(ExceptionCode::BILLING_AUTH_FAIL);
            }
            /* Get the provider */
            $exchange = $billingables[$type];
            /* Check provider type */
            if (Janitor::getGuestType($this) !== $exchange) {
                throw new ExceptionCode(ExceptionCode::BILLING_AUTH_FAIL);
            }

            $config = Janitor::getGuestData($exchange);
        
            $minAmount = (isset($config['billing_min_amount']) && is_array($config['billing_min_amount']) ? $config['billing_min_amount'] : []);
                   
            $maxAmount = (isset($config['billing_max_amount']) && is_array($config['billing_max_amount']) ? $config['billing_max_amount'] : []);
            /* Validator amount */
            try {
                Validator::make(['amount' => $data['amount']], ['amount' => 'required|amount_verifier:' . $minAmount[$type] . ',' . $maxAmount[$type]])->validate();
            } catch (\Throwable $e) {
                if ($e instanceof ValidationException) {
                    throw new ExceptionCode(ExceptionCode::BILLING_AUTH_FAIL);
                }
                throw $e;
            }
            /* Get the user */
            $expires = Carbon::now()->addMinutes(TokenAuth::getTTL($data['model']) ?: config('jwt.ttl', 60));
            $user = Cache::remember(TokenAuth::getCacheKey($data['id'], $guard), $expires, function () use ($data) {
                return app($data['model'])->find($data['id']);
            });
            /* User to billing */
            if ($user) {

                $user->verifyHoldStatusOnFail();

                $client = $data['client'];

                $appId = $data['app_id'];

                $amount = $data['amount'];

                /* Logic function */

                $parameter = [];

                $parameter['AppId'] = $appId;

                $parameter['User'] = $user;
                /*
                Object
                Y
                ??????
                */

                $parameter['Amount'] = $amount;
                /*
                Integer
                Y
                ??????
                */
                $parameter['ItemName'] = null;
                /*
                String(50)
                N
                ????????????
                */
        
                $parameter['ItemDesc'] = null;
                /*
                String(50)
                N
                ????????????
                */
        
                $parameter['Remark'] = null;
                /*
                String(50)
                N
                ??????
                */

                switch ($type) {
                    case 'store':
                        $info = StoreBilling::input($parameter)->run();
                    break;
                    case 'atm':
                        $info = AtmBilling::input($parameter)->run();
                    break;
                    case 'credit':
                        $info = CreditBilling::input($parameter)->run();
                    break;
                    case 'transfer':
                        $info = TransferBilling::input($parameter)->run();
                    break;
                }

                $message = 'Currently unavailable.';

                if (isset($info)) {
                    if ($info['success']) {
                        exit($info['data']['html']);
                    } else {
                        $message = $info['data']['message'];
                    }
                }

                throw new ServiceExceptionCode(ServiceExceptionCode::BILLING_TO_PAYMENT_FAIL, ['%message%' => $message], ['%message%' => $message]);
            }
        }
        throw new ServiceExceptionCode(ServiceExceptionCode::BILLING_AUTH_FAIL);
    }

    /**
     * Payment
     *
     * Payment notification callback.
     *
     * ### Response Body
     *
     * error : 0
     *
     * content :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * msg | STR | Message
     *
     * @bodyParam error INT required Error number Example: {error}
     * @bodyParam content OBJ required Content info Example: {content}
     * @bodyParam Signature STR required Signature code Example: {Signature}
     * 
     * @response
     * {
     *    "error": 0,
     *    "content": {
     *        "msg": "ok"
     *    }
     * }
     *
     * @param  PaydayThirdCreateRequest $request
     * @param  PaydayThirdCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(PaydayThirdCreateRequest $request, PaydayThirdCreateResponse $response)
    {
        $error = 2;
        $message = 'Program error';
        try {
            // DB Transaction begin
            DB::beginTransaction();

            $config = Janitor::getGuestData(Janitor::getGuestType($this));

            $data = $request->only([
                'error',
                'content',
                'Signature'
            ]);
            /* Ckeck input */
            Validator::make($data, [
                'error' => 'required',
                'content' => 'required',
                'Signature' => 'required'
            ])->validate();
            // $data['content']['msg'];// ????????????
            // $data['content']['DistributorId']; // ????????????
            // $data['content']['OrderBillNo']; // ??????????????????
            // $data['content']['Amount']; // ????????????
            // $data['content']['Category'];
            /*
            ????????????
            1 ????????????
            2 ??????ATM
            3 ?????????
            4 ??????
            */
            // $data['content']['CustomCol']; // ?????????????????????
            // $data['content']['TradeNo']; // ????????????????????????
            // $data['content']['TradeDate']; // ????????????????????????
            // $data['content']['Status']; // ???????????????1 ????????????????????????
            
            // if ($data['content']['Category'] == 1) {
            //     $data['content']['PaymentNo']; // ????????????
            //     $data['content']['ExpireDate']; // ????????????
            // }
            // if ($data['content']['Category'] == 2) {
            //     $data['content']['BankCode']; // ??????????????????
            //     $data['content']['BankName']; // ??????????????????
            //     $data['content']['Account']; // ??????????????????
            //     $data['content']['ExpireDate']; // ????????????
            // }
            /* Check data */
            $signature = md5($config['client_id'] . $data['content']['OrderBillNo'] . $data['content']['TradeNo'] . $data['content']['Status'] . $config['client_secret']);

            if ($signature === $data['Signature']) {
                $order = $this->repository->pickOrderMainSerial($data['content']['OrderBillNo']);
                $order = $order::where('id', $order->id)->lockForUpdate()->first();
                /* Check order type */
                if ($order->formdefine_type === 'billing') {
                    /* Check order status */  
                    if ($order->status === 'billing') {
                        $user = $order->sourceable_type::find($order->sourceable_id);
                        $note = $order->memo['note'];
                        $note['trade_order'] = $data['content']['TradeNo'];
                        $note['trade_date'] = $data['content']['TradeDate'];
                        if ($data['content']['Category'] == 1) {
                            $note['payment_no'] = $data['content']['PaymentNo']; // ????????????
                            $note['expire_date'] = $data['content']['ExpireDate']; // ????????????
                        }
                        if ($data['content']['Category'] == 2) {
                            $note['bank_code'] = $data['content']['BankCode']; // ??????????????????
                            $note['bank_name'] = $data['content']['BankName']; // ??????????????????
                            $note['virtual_account'] = $data['content']['Account']; // ??????????????????
                            $note['expire_date'] = $data['content']['ExpireDate']; // ????????????
                        }
                        if ($data['content']['Status'] == 1) {
                            $user->submitReceipt('payment', [
                            'label' => $order->memo['label'],
                            'content' => 'Notify to payment.',
                            'note' => $note
                        ], $order);

                            $error = 0;
                            $message = 'ok';
                        } else {
                            $note['msg'] = $data['content']['msg'];
                            $user->submitReceipt('interrupt', [
                            'label' => $order->memo['label'],
                            'content' => 'Payment interrupted.',
                            'note' => $note
                        ], $order);

                            $message = 'Status is failure';
                        }

                        DB::commit();
                    } else {
                        $message = 'Order status has changed';
                    }
                } else {
                    $message = 'Wrong order type';
                }
            } else {
                $message = 'Signature error'; 
            }
        } catch (\Throwable $e) {
            DB::rollback();
            $error = 2;
            $message = 'Program error';
        }
        /* Return message */
        $return = [
            'error' => $error,
            'content' => [
                'msg' => $message
            ]
        ];
        /* Response */
        return $response->json($return);
    }

    /**
     * Deposit
     *
     * Deposit notification callback.
     *
     * ### Response Body
     *
     * error : 0
     *
     * content :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * msg | STR | Message
     *
     * @bodyParam error INT required Error number Example: {error}
     * @bodyParam content OBJ required Content info Example: {content}
     * @bodyParam Signature STR required Signature code Example: {Signature}
     * 
     * @response
     * {
     *    "error": 0,
     *    "content": {
     *        "msg": "ok"
     *    }
     * }
     * 
     * @param  PaydayThirdCreateRequest $request
     * @param  PaydayThirdCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function deposit(PaydayThirdCreateRequest $request, PaydayThirdCreateResponse $response)
    {
        $error = 2;
        $message = 'Program error';
        try {
            // DB Transaction begin
            DB::beginTransaction();

            $config = Janitor::getGuestData(Janitor::getGuestType($this));

            $data = $request->only([
                'error',
                'content',
                'Signature'
            ]);
            /* Ckeck input */
            Validator::make($data, [
                'error' => 'required',
                'content' => 'required',
                'Signature' => 'required'
            ])->validate();
            // $data['content']['msg'];// ????????????
            // $data['content']['DistributorId']; // ????????????
            // $data['content']['OrderBillNo']; // ??????????????????
            // $data['content']['Amount']; // ????????????
            // $data['content']['Category'];
            /*
            ????????????
            1 ????????????
            2 ??????ATM
            3 ?????????
            4 ??????
            */
            // $data['content']['CustomCol']; // ?????????????????????
            // $data['content']['TradeNo']; // ????????????????????????
            // $data['content']['TradeDate']; // ????????????????????????
            // $data['content']['Status']; // ???????????????1 ????????????????????????

            // if ($data['content']['Category'] == 1) {
            //     $data['content']['PayFrom'];
            //     /*
            //     ????????????
            //     ibon -> 7-11
            //     family -> ??????
            //     okmart -> OK
            //     hilife -> ?????????
            //     */
            //     $data['content']['PaymentNo']; // ????????????
            // }
            // if ($data['content']['Category'] == 2) {
            //     $data['content']['BankCode']; // ?????????????????? (???????????????)
            //     $data['content']['Account']; // ?????????????????? (???????????????)
            // }
            /* Check data */
            $signature = md5($config['client_id'] . $data['content']['OrderBillNo'] . $data['content']['TradeNo'] . $data['content']['Status'] . $config['client_secret']);

            if ($signature === $data['Signature']) {
                $order = $this->repository->pickOrderMainSerial($data['content']['OrderBillNo']);
                $order = $order::where('id', $order->id)->lockForUpdate()->first();
                /* Check order type */
                if ($order->formdefine_type === 'billing') {
                  /* Check order status */  
                    if ($order->status === 'payment') {
                        $user = $order->sourceable_type::find($order->sourceable_id);
                        $note = $order->memo['note'];
                        $note['trade_order'] = $data['content']['TradeNo'];
                        $note['trade_date'] = $data['content']['TradeDate'];
                        if ($data['content']['Category'] == 1) {
                            $note['pay_from'] = $data['content']['PayFrom'];
                            /*
                            ????????????
                            ibon -> 7-11
                            family -> ??????
                            okmart -> OK
                            hilife -> ?????????
                            */
                            $note['payment_no'] = $data['content']['PaymentNo']; // ????????????
                        }
                        if ($data['content']['Category'] == 2) {
                            $note['bank_code'] = $data['content']['BankCode']; // ?????????????????? (???????????????)
                            $note['virtual_account'] = $data['content']['Account']; // ?????????????????? (???????????????)
                        }
                        if ($data['content']['Status'] == 1) {
                            $user->submitReceipt('deposit', [
                                'label' => $order->memo['label'],
                                'content' => 'Deposit finish.',
                                'note' => $note
                            ], $order);

                            $account = $user->tradeAccount(Gold::class);

                            $account = $account->where('id', $account->id)->lockForUpdate()->first();
                            
                            $target = TokenAuth::model()::find(app(TokenAuth::model())->asPrimaryId($note['app_id']));

                            $trade = $account->beginTradeAmount($target);
                            // Amount of income by trade
                            $trade->amountOfIncome($note['amount'], [
                                'label' => $order->memo['label'],
                                'content' => 'Income deposit.',
                                'note' => [
                                    'provider' => $note['provider'],
                                    'receipt' => $order->order
                                ]
                            ]);
                            // Transaction notification from system
                            $trade->tradeNotify();
                            $error = 0;
                            $message = 'ok';
                        } else {
                            $note['msg'] = $data['content']['msg'];
                            $user->submitReceipt('interrupt', [
                                'label' => $order->memo['label'],
                                'content' => 'Deposit interrupted.',
                                'note' => $note
                            ], $order);
                            
                            $message = 'Status is failure';
                        }

                        DB::commit();
                    } else {
                        $message = 'Order status has changed';
                    }
                } else {
                    $message = 'Wrong order type';
                }
            } else {
                $message = 'Signature error'; 
            }
        } catch (\Throwable $e) {
            DB::rollback();
            $error = 2;
            $message = 'Program error';
        }
        /* Return message */
        $return = [
            'error' => $error,
            'content' => [
                'msg' => $message
            ]
        ];
        /* Response */
        return $response->json($return);
    }
}