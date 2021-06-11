<?php

namespace App\Http\Controllers\Exchange;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Exchange\ServiceCreateRequest;
use App\Http\Requests\Exchange\ServiceUpdateRequest;
use App\Http\Responses\Exchange\ServiceCreateResponse;
use App\Http\Responses\Exchange\ServiceUpdateResponse;
use App\Exceptions\Exchange\ServiceExceptionCode as ExceptionCode;
use App\Exceptions\Jwt\AuthExceptionCode;
use App\Repositories\Receipt\OperateRepository;
use App\Exceptions\Trade\OperateExceptionCode as TradeExceptionCode;
use App\Exceptions\Member\AuthExceptionCode as MemberExceptionCode;
use App\Libraries\Instances\Router\Janitor;
use TokenAuth;
use StorageSignature;
use Lang;
use Validator;
use App\Entities\Admin\Auth as Admin;
use App\Entities\Member\Auth as Member;
use App\Entities\Account\Gold;
use Hash;
use DB;
use App\Notifications\User\Account\Withdraw;
use Str;

/**
 * @group
 *
 * Exchange Service
 *
 * @package namespace App\Http\Controllers\Exchange;
 */
class ServiceController extends Controller
{
    /**
     * @var OperateRepository
     */
    protected $repository;

    /**
     * ServiceController constructor.
     * 
     * @param OperateRepository $repository
     */
    public function __construct(OperateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Billing Types
     *
     * Get a list of billing types for link.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * type | STR | Billing type code
     * min_amount | INT | Minimum amount allowed
     * max_amount | INT | Maximum amount allowed
     * description | STR | Type about description
     * 
     * @response
     * {
     *    "success": true,
     *    "data": [
     *        {
     *            "type": "store",
     *            "min_amount": 100,
     *            "max_amount": 6000,
     *            "description": "Store collection code"
     *        },
     *        {
     *            "type": "atm",
     *            "min_amount": 100,
     *            "max_amount": 6000,
     *            "description": "Virtual ATM"
     *        },
     *        {
     *            "type": "credit",
     *            "min_amount": 100,
     *            "max_amount": 6000,
     *            "description": "Credit card"
     *        },
     *        {
     *            "type": "transfer",
     *            "min_amount": 100,
     *            "max_amount": 6000,
     *            "description": "Bank transfer"
     *        }
     *    ]
     * }
     *
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function billingTypes(ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Get the billingables */
        $billingables = config('exchange.billingables');

        $source = collect($billingables)->map(function ($exchange, $key) {
            /* Check the service */
            if (isset($exchange[0]) && Janitor::isAllowed(Janitor::getGuestClass($exchange), 'exchange')) {
                $config = Janitor::getGuestData($exchange);

                $minAmount = (isset($config['billing_min_amount']) && is_array($config['billing_min_amount']) ? $config['billing_min_amount'] : []);
                
                $maxAmount = (isset($config['billing_max_amount']) && is_array($config['billing_max_amount']) ? $config['billing_max_amount'] : []);
                
                if (isset($minAmount[$key], $maxAmount[$key])) {
                    $description = Lang::dict('exchange', 'billingables.'. $key, 'Undefined');
                    return [
                        'type' => $key,
                        'min_amount' => (int) $minAmount[$key],
                        'max_amount' => (int) $maxAmount[$key],
                        'description' => $description
                    ];
                }
            }
            return null;
        })->reject(function ($item) {
            return empty($item);
        })->keyBy('type')->all();

        return $response->success(['data' => array_values($source)]);
    }

    /**
     * Billing Link
     *
     * Get the billing link for the specified amount.
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
     * @bodyParam amount STR required Amount Example: {amount}
     * @bodyParam type STR required Billing type code Example: {type}
     * 
     * @response
     * {
     *    "success": true,
     *    "data": {
     *        "link": "http://www.example.com/8466b336802941ac8df1bd3173bdeb8de1fabcec5fbb036f0c08c550a738b182abab2d07",
     *        "expires_in": 680
     *    }
     * }
     *
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function billingLink(ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check user */
        if ($user = TokenAuth::getUser(Member::class)) {
            /* Get the billingables */
            $billingables = config('exchange.billingables');

            $type = $request->input('type');

            /* Check billing type */
            if (! isset($billingables[$type])) {
                throw new ExceptionCode(ExceptionCode::BILLING_TYPE_UNDEFINED);
            }
            /* Get the provider */
            $exchange = $billingables[$type];
            /* Check the service */
            if (! isset($exchange[0]) || ! Janitor::isAllowed(Janitor::getGuestClass($exchange), 'exchange')) {
                throw new ExceptionCode(ExceptionCode::UNAVAILABLE_SERVICE);
            }

            $config = Janitor::getGuestData($exchange);

            $minAmount = (isset($config['billing_min_amount']) && is_array($config['billing_min_amount']) ? $config['billing_min_amount'] : []);
                   
            $maxAmount = (isset($config['billing_max_amount']) && is_array($config['billing_max_amount']) ? $config['billing_max_amount'] : []);

            /* Validator input amount */
            Validator::make(['amount' => $request->input('amount')], ['amount' => 'required|amount_verifier:' . $minAmount[$type] . ',' . $maxAmount[$type]])->validate();

            $client = TokenAuth::getClient();
            /* Auth target */
            $data = [
                'client' => $client->id,
                'app_id' => $client->app_id,
                'model' => get_class($user),
                'id' => $user->id,
                'amount' => $request->input('amount'),
                'type' => $type
            ];
            $ttl = config('exchange.billing_link_ttl');
            $ttl = ($ttl > 0 ? $ttl : 5);
            /* Save auth unique code */
            if ($code = StorageSignature::build($data, $ttl)) {
                /* Return authorization signature link */
                $source = [
                    'link' => Str::replaceLast('{code}', $code, $config['billing_url']),
                    'expires_in' => $ttl * 60
                ];
                
                return $response->success($source);
            }
            throw new ExceptionCode(ExceptionCode::BILLING_LINK_CREATE_FAIL);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Manual Billing
     *
     * Use payment authorization for manual transactions.
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
     * memo.note | OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @bodyParam amount STR required Amount Example: {amount}
     * @bodyParam name STR Item name Example: {remark}
     * @bodyParam desc STR Item description Example: {desc}
     * @bodyParam remark STR Remark message Example: {remark}
     * 
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "4202101040102",
     *       "serial": "4202101040102",
     *       "source_id": "1294583",
     *       "source": "member",
     *       "source_name": "Member",
     *       "code": 502,
     *       "form": "manual_billing",
     *       "form_name": "Manual Billing",
     *       "status": "manual_billing",
     *       "memo": {
     *           "label": "manual",
     *           "content": "Billing Start",
     *           "note": {
     *               "desc": "",
     *               "name": "",
     *               "amount": "100",
     *               "app_id": "6398211294583",
     *               "remark": "",
     *               "category": "manual",
     *               "provider": "system"
     *           }
     *       },
     *       "created_at": "2021-01-04 11:02:21",
     *       "updated_at": "2021-01-04 11:02:21"
     *    }
     * }
     *
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function manualBilling(ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check user */
        if ($user = TokenAuth::getUser(Member::class)) {
            try {
                // DB Transaction begin
                DB::beginTransaction();

                $note = [
                    'app_id' => TokenAuth::getClient()->app_id,
                    'provider' => 'system',
                    'amount' => $request->input('amount'),
                    'name' => $request->input('name'),
                    'desc' => $request->input('desc'),
                    'remark' => $request->input('remark')
                ];

                $order = $user->submitReceipt('manual_billing', [
                    'label' => 'manual',
                    'content' => 'Billing request.',
                    'note' => $note
                ]);

                /* Transformer */
                $transformer = app($this->repository->presenter())->getTransformer();
                /* Array Info */
                $info = $transformer->transform($order);
                        
                DB::commit();
                
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Manual Payment
     *
     * Manual payment confirmation notification.
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
     * memo.note | OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @bodyParam remark STR Remark message Example: {remark}
     * @urlParam order required Receipt order serial id Example: 4202101040102
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "4202101040102",
     *       "serial": "5202101040202",
     *       "source_id": "1294583",
     *       "source": "admin",
     *       "source_name": "Admin",
     *       "code": 603,
     *       "form": "manual_payment",
     *       "form_name": "Manual Payment",
     *       "status": "manual_payment",
     *       "memo": {
     *           "label": "manual",
     *           "content": "Notify Payment",
     *           "note": {
     *               "desc": "",
     *               "name": "",
     *               "amount": "100",
     *               "app_id": "6398211294583",
     *               "remark": "",
     *               "category": "manual",
     *               "provider": "system"
     *           }
     *       },
     *       "created_at": "2021-01-04 12:02:21",
     *       "updated_at": "2021-01-04 12:02:21"
     *    }
     * }
     *
     * @param string $order
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function manualPayment($order, ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check admin */
        if ($admin = TokenAuth::getUser(Admin::class)) {
            try {
                // DB Transaction begin
                DB::beginTransaction();

                $order = $this->repository->pickOrderMainSerial($order);

                $order = $order::where('id', $order->id)->lockForUpdate()->first();
                /* Check order type */
                if ($order->formdefine_type === 'manual_billing') {
                    /* Check order status */
                    if ($order->status === 'manual_billing') {
                        $note = $order->memo['note'];

                        $note['remark'] = $request->input('remark');
                        
                        $order = $admin->submitReceipt('manual_payment', [
                            'label' => $order->memo['label'],
                            'content' => 'Notify to payment.',
                            'note' => $note
                        ], $order);
                        /* Transformer */
                        $transformer = app($this->repository->presenter())->getTransformer();
                        /* Array Info */
                        $info = $transformer->transform($order);
                    } else {
                        throw new ExceptionCode(ExceptionCode::INVALID_ORDER_STATUS);
                    }
                } else {
                    throw new ExceptionCode(ExceptionCode::ORDER_TYPE_WRONG);
                }
            
                DB::commit();
                
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Manual Deposit
     *
     * Manual deposit confirmation notification.
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
     * memo.note | OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @bodyParam remark STR Remark message Example: {remark}
     * @urlParam order required Receipt order serial id Example: 4202101040102
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "4202101040102",
     *       "serial": "6202101040302",
     *       "source_id": "1294583",
     *       "source": "admin",
     *       "source_name": "Admin",
     *       "code": 703,
     *       "form": "manual_deposit",
     *       "form_name": "Manual Deposit",
     *       "status": "manual_deposit",
     *       "memo": {
     *           "label": "manual",
     *           "content": "Notify Deposit",
     *           "note": {
     *               "desc": "",
     *               "name": "",
     *               "amount": "100",
     *               "app_id": "6398211294583",
     *               "remark": "",
     *               "category": "manual",
     *               "provider": "system"
     *           }
     *       },
     *       "created_at": "2021-01-04 13:02:21",
     *       "updated_at": "2021-01-04 13:02:21"
     *    }
     * }
     * 
     * @param string $order
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function manualDeposit($order, ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check admin */
        if ($admin = TokenAuth::getUser(Admin::class)) {
            try {
                // DB Transaction begin
                DB::beginTransaction();

                $order = $this->repository->pickOrderMainSerial($order);

                $order = $order::where('id', $order->id)->lockForUpdate()->first();
                /* Check order type */
                if ($order->formdefine_type === 'manual_billing') {
                    /* Check order subform */
                    if ($order->status === 'manual_payment') {
                        $user = $order->sourceable_type::find($order->sourceable_id);
        
                        $note = $order->memo['note'];

                        $note['remark'] = $request->input('remark');
                
                        $order = $admin->submitReceipt('manual_deposit', [
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
                        /* Transformer */
                        $transformer = app($this->repository->presenter())->getTransformer();
                        /* Array Info */
                        $info = $transformer->transform($order);
                    } else {
                        throw new ExceptionCode(ExceptionCode::INVALID_ORDER_STATUS);
                    }
                } else {
                    throw new ExceptionCode(ExceptionCode::ORDER_TYPE_WRONG);
                }
            
                DB::commit();
                
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Manual Trade Interrupt
     *
     * Interrupt manual transactions.
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
     * memo.note | OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @bodyParam remark STR Remark message Example: {remark}
     * @urlParam order required Receipt order serial id Example: 4202101040102
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "4202101040102",
     *       "serial": "5202101040302",
     *       "source_id": "1294583",
     *       "source": "admin",
     *       "source_name": "Admin",
     *       "code": 803,
     *       "form": "manual_interrupt",
     *       "form_name": "Manual Interrupt",
     *       "status": "manual_interrupt",
     *       "memo": {
     *           "label": "manual",
     *           "content": "Billing Interrupt",
     *           "note": {
     *               "desc": "",
     *               "name": "",
     *               "amount": "100",
     *               "app_id": "6398211294583",
     *               "remark": "",
     *               "category": "manual",
     *               "provider": "system"
     *           }
     *       },
     *       "created_at": "2021-01-04 13:02:21",
     *       "updated_at": "2021-01-04 13:02:21"
     *    }
     * }
     * 
     * @param string $order
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function manualInterrupt($order, ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check user */
        if (($user = TokenAuth::getUser(Member::class)) || ($user = TokenAuth::getUser(Admin::class))) {
            try {
                // DB Transaction begin
                DB::beginTransaction();

                $order = $this->repository->pickOrderMainSerial($order);

                $order = $order::where('id', $order->id)->lockForUpdate()->first();
                /* Check order type */
                if ($order->formdefine_type === 'manual_billing') {
                    /* Check order status */
                    if ((($user instanceof Member || $user instanceof Admin) && $order->status === 'manual_billing') || ($user instanceof Admin && $order->status === 'manual_payment')) {

                        $note = $order->memo['note'];

                        $note['remark'] = $request->input('remark');
                
                        $order = $user->submitReceipt('manual_interrupt', [
                            'label' => $order->memo['label'],
                            'content' => ($order->status === 'manual_billing' ? 'Interruption of billing.' : 'Payment interrupted.'),
                            'note' => $note
                        ], $order);

                        /* Transformer */
                        $transformer = app($this->repository->presenter())->getTransformer();
                        /* Array Info */
                        $info = $transformer->transform($order);
                    } else {
                        throw new ExceptionCode(ExceptionCode::INVALID_ORDER_STATUS);
                    }
                } else {
                    throw new ExceptionCode(ExceptionCode::ORDER_TYPE_WRONG);
                }
            
                DB::commit();
                
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Withdraw Deposit
     *
     * Apply for withdrawal of deposit.
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
     * memo.note | OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @bodyParam pin STR required User pin code Example: {pin}
     * @bodyParam amount STR required Amount Example: {amount}
     * @bodyParam remark STR Remark message Example: {remark}
     * 
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "8202101040102",
     *       "serial": "8202101040102",
     *       "source_id": "1294583",
     *       "source": "member",
     *       "source_name": "Member",
     *       "code": 902,
     *       "form": "withdraw_deposit",
     *       "form_name": "Withdraw Deposit",
     *       "status": "withdraw_deposit",
     *       "memo": {
     *           "label": "withdraw",
     *           "content": "Withdraw Start",
     *           "note": {
     *               "amount": "100",
     *               "bank": "77777-77777-7777-777", 
     *               "app_id": "6398211294583",
     *               "remark": "",
     *               "provider": "system"
     *           }
     *       },
     *       "created_at": "2021-01-04 11:02:21",
     *       "updated_at": "2021-01-04 11:02:21"
     *    }
     * }
     *
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function withdrawDeposit(ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check user */
        if ($user = TokenAuth::getUser(Member::class)) {
            /* Check pin */
            if (! $user->getAuthPin()) {
                throw new MemberExceptionCode(MemberExceptionCode::PIN_CODE_UNDEFINED);
            }
            if (!Hash::check($request->input('pin'), $user->getAuthPin())) {
                throw new MemberExceptionCode(MemberExceptionCode::PIN_FAIL);
            }
            /* Check bank */
            if (! isset($user->setting['bank'][0])) {
                throw new MemberExceptionCode(MemberExceptionCode::BANK_ACCOUNT_UNDEFINED);
            }
            try {
                // DB Transaction begin
                DB::beginTransaction();

                $account = $user->tradeAccount(Gold::class);

                $account = $account->where('id', $account->id)->lockForUpdate()->first();

                $amount = $request->input('amount');

                if ($account->amount < $amount) {
                    throw new TradeExceptionCode(TradeExceptionCode::INVALID_AMOUNT);
                }

                $target = TokenAuth::getClient();

                $note = [
                    'provider' => 'system',
                    'app_id' => $target->app_id,
                    'amount' => $amount,
                    'remark' => $request->input('remark'),
                    'bank' => $user->setting['bank']
                ];

                $order = $user->submitReceipt('withdraw_deposit', [
                    'label' => 'withdraw',
                    'content' => 'Request for withdrawal.',
                    'note' => $note
                ]);

                $trade = $account->beginTradeAmount($target);
                // Amount of expenses by trade
                $trade->amountOfExpenses($note['amount'], [
                    'label' => 'withdraw',
                    'content' => 'Make a withdrawal.',
                    'note' => [
                        'provider' => $note['provider'],
                        'receipt' => $order->order
                    ]
                ]);
                // Transaction notification from system
                $trade->tradeNotify();
                /* Transformer */
                $transformer = app($this->repository->presenter())->getTransformer();
                /* Array Info */
                $info = $transformer->transform($order);
                        
                DB::commit();
                
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Remittance
     *
     * Approval remittance to update the status.
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
     * memo.note | OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @bodyParam remark STR Remark message Example: {remark}
     * @urlParam order required Receipt order serial id Example: 8202101040102
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "8202101040102",
     *       "serial": "9202101040102",
     *       "source_id": "1294583",
     *       "source": "admin",
     *       "source_name": "Admin",
     *       "code": 1003,
     *       "form": "remittance",
     *       "form_name": "Remittance",
     *       "status": "remittance",
     *       "memo": {
     *           "label": "withdraw",
     *           "content": "Remittance",
     *           "note": {
     *               "amount": "100",
     *               "bank": "77777-77777-7777-777", 
     *               "app_id": "6398211294583",
     *               "remark": "",
     *               "provider": "system"
     *           }
     *       },
     *       "created_at": "2021-01-04 15:02:21",
     *       "updated_at": "2021-01-04 15:02:21"
     *    }
     * }
     *
     * @param string $order
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function remittance($order, ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check admin */
        if ($admin = TokenAuth::getUser(Admin::class)) {
            try {
                // DB Transaction begin
                DB::beginTransaction();

                $order = $this->repository->pickOrderMainSerial($order);

                $order = $order::where('id', $order->id)->lockForUpdate()->first();
                /* Check order type */
                if ($order->formdefine_type === 'withdraw_deposit') {
                    /* Check order status */
                    if ($order->status === 'withdraw_deposit') {

                        $note = $order->memo['note'];

                        $note['remark'] = $request->input('remark');
                        
                        $order = $admin->submitReceipt('remittance', [
                            'label' => $order->memo['label'],
                            'content' => 'Notify to remittance.',
                            'note' => $note
                        ], $order);
                        /* Transformer */
                        $transformer = app($this->repository->presenter())->getTransformer();
                        /* Array Info */
                        $info = $transformer->transform($order);
                    } else {
                        throw new ExceptionCode(ExceptionCode::INVALID_ORDER_STATUS);
                    }
                } else {
                    throw new ExceptionCode(ExceptionCode::ORDER_TYPE_WRONG);
                }
            
                DB::commit();
                
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Remittance Finish
     *
     * The remittance has been completed to update the status.
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
     * memo.note | OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @bodyParam remark STR Remark message Example: {remark}
     * @urlParam order required Receipt order serial id Example: 8202101040102
     *
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "8202101040102",
     *       "serial": "9202101040102",
     *       "source_id": "1294583",
     *       "source": "admin",
     *       "source_name": "Admin",
     *       "code": 1103,
     *       "form": "remittance_finish",
     *       "form_name": "Remittance Finish",
     *       "status": "remittance_finish",
     *       "memo": {
     *           "label": "withdraw",
     *           "content": "Remittance Finish",
     *           "note": {
     *               "amount": "100",
     *               "bank": "77777-77777-7777-777", 
     *               "app_id": "6398211294583",
     *               "remark": "",
     *               "provider": "system"
     *           }
     *       },
     *       "created_at": "2021-01-04 16:02:21",
     *       "updated_at": "2021-01-04 16:02:21"
     *    }
     * }
     *
     * @param string $order
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function remittanceFinish($order, ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check admin */
        if ($admin = TokenAuth::getUser(Admin::class)) {
            try {
                // DB Transaction begin
                DB::beginTransaction();

                $order = $this->repository->pickOrderMainSerial($order);

                $order = $order::where('id', $order->id)->lockForUpdate()->first();
                /* Check order type */
                if ($order->formdefine_type === 'withdraw_deposit') {
                    /* Check order status */
                    if ($order->status === 'remittance') {

                        $user = $order->sourceable_type::find($order->sourceable_id);

                        $note = $order->memo['note'];

                        $note['remark'] = $request->input('remark');
                        
                        $order = $admin->submitReceipt('remittance_finish', [
                            'label' => $order->memo['label'],
                            'content' => 'Remittance finish.',
                            'note' => $note
                        ], $order);
                        // Notify remittance finish
                        $user->notify(new Withdraw($order));
                        /* Transformer */
                        $transformer = app($this->repository->presenter())->getTransformer();
                        /* Array Info */
                        $info = $transformer->transform($order);
                    } else {
                        throw new ExceptionCode(ExceptionCode::INVALID_ORDER_STATUS);
                    }
                } else {
                    throw new ExceptionCode(ExceptionCode::ORDER_TYPE_WRONG);
                }
            
                DB::commit();
                
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }

    /**
     * Cancel Withdraw
     *
     * Cancel withdrawal.
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
     * memo.note | OBJ | Receipt memo note
     * created_at | STR | Datetime when the receipt was created
     * updated_at | STR | Datetime when the receipt was updated
     *
     * @bodyParam remark STR Remark message Example: {remark}
     * @urlParam order required Receipt order serial id Example: 8202101040102
     * 
     * @response
     * {
     *    "success": true,
     *    "data": {
     *       "order": "8202101040102",
     *       "serial": "10202101040102",
     *       "source_id": "1294583",
     *       "source": "member",
     *       "source_name": "Member",
     *       "code": 1202,
     *       "form": "withdraw_interrupt",
     *       "form_name": "Withdraw Interrupt",
     *       "status": "withdraw_interrupt",
     *       "memo": {
     *           "label": "withdraw",
     *           "content": "Withdraw Interrupt",
     *           "note": {
     *               "amount": "100",
     *               "bank": "77777-77777-7777-777", 
     *               "app_id": "6398211294583",
     *               "remark": "",
     *               "provider": "system"
     *           }
     *       },
     *       "created_at": "2021-01-04 11:02:21",
     *       "updated_at": "2021-01-04 11:02:21"
     *    }
     * }
     *
     * @param string $order
     * @param  ServiceCreateRequest $request
     * @param  ServiceCreateResponse $response
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelWithdraw($order, ServiceCreateRequest $request, ServiceCreateResponse $response)
    {
        /* Check user */
        if (($user = TokenAuth::getUser(Member::class)) || ($user = TokenAuth::getUser(Admin::class))) {
            try {
                // DB Transaction begin
                DB::beginTransaction();

                $order = $this->repository->pickOrderMainSerial($order);

                $order = $order::where('id', $order->id)->lockForUpdate()->first();
                /* Check order type */
                if ($order->formdefine_type === 'withdraw_deposit') {
                    /* Check order status */
                    if ((($user instanceof Member || $user instanceof Admin) && $order->status === 'withdraw_deposit') || ($user instanceof Admin && $order->status === 'remittance')) {

                        $account = $order->sourceable_type::find($order->sourceable_id);

                        $note = $order->memo['note'];

                        $note['remark'] = $request->input('remark');
                
                        $order = $user->submitReceipt('withdraw_interrupt', [
                            'label' => $order->memo['label'],
                            'content' => ($order->status === 'withdraw_deposit' ? 'Withdrawal interrupted.' : 'Remittance interrupted.'),
                            'note' => $note
                        ], $order);

                        $account = $account->tradeAccount(Gold::class);

                        $account = $account->where('id', $account->id)->lockForUpdate()->first();

                        $target = TokenAuth::model()::find(app(TokenAuth::model())->asPrimaryId($note['app_id']));

                        $trade = $account->beginTradeAmount($target);
                        // Amount of income by trade
                        $trade->amountOfIncome($note['amount'], [
                            'label' => $order->memo['label'],
                            'content' => 'Income due to cancellation of withdrawal.',
                            'note' => [
                                'provider' => $note['provider'],
                                'receipt' => $order->order
                            ]
                        ]);
                        // Transaction notification from system
                        $trade->tradeNotify();
                        /* Transformer */
                        $transformer = app($this->repository->presenter())->getTransformer();
                        /* Array Info */
                        $info = $transformer->transform($order);
                    } else {
                        throw new ExceptionCode(ExceptionCode::INVALID_ORDER_STATUS);
                    }
                } else {
                    throw new ExceptionCode(ExceptionCode::ORDER_TYPE_WRONG);
                }
            
                DB::commit();
                
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }

            return $response->success($info);
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}