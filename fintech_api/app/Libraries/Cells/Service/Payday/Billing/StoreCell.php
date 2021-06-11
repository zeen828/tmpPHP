<?php

namespace App\Libraries\Cells\Service\Payday\Billing;

use App\Libraries\Abstracts\Base\Cell as CellBase;
use App\Libraries\Instances\Router\Janitor;
use App\Exceptions\Exchange\PaydayThirdExceptionCode as ExceptionCode;
use App\Entities\Member\Auth as Member;
use TokenAuth;
use Lang;
use DB;

/**
 * Final Class StoreCell.
 *
 * @package App\Libraries\Cells\Service\Payday\Billing
 */
final class StoreCell extends CellBase
{

    /**
     * The cell label
     *
     * @var string
     */
    private $label = 'store';

    /**
     * The cell category number
     *
     * @var int
     */
    private $category = 1;

    /**
     * Get the controller name.
     * 
     * @return string
     */
    private function controller(): string
    {
        return \App\Http\Controllers\Exchange\PaydayThirdController::class;
    }

    /**
     * Get the config data.
     * 
     * @param string $key
     * 
     * @return mixed
     */
    private function config($key)
    {
        $config = Janitor::getGuestData(Janitor::getGuestType($this->controller()));

        return (isset($config[$key]) ? $config[$key] : null);
    }

    /**
     * Get the validation rules that apply to the arguments input.
     *
     * @return array
     */
    protected function rules(): array
    {
        $minAmount = $this->config('billing_min_amount');

        $minAmount = (isset($minAmount) && is_array($minAmount) ? $minAmount : []);

        $maxAmount = $this->config('billing_max_amount');

        $maxAmount = (isset($maxAmount) && is_array($maxAmount) ? $maxAmount : []);

        return [
            
            'AppId' =>  [
                'required',
                'regex:/^[1-9]{1}[0-9]*$/'
            ],

            'User' => 'required|object_verifier:'. Member::class,

            'Amount' => 'required|amount_verifier:' . $minAmount[$this->label] . ',' . $maxAmount[$this->label],
            /*
            Integer
            Y
            金額
            */
            'ItemName' => 'nullable|between:1,50',
            /*
            String(50)
            N
            商品名稱
            */
            'ItemDesc' => 'nullable|between:1,50',
            /*
            String(50)
            N
            商品描述
            */
            'Remark' => 'nullable|between:1,50',
            /*
            String(50)
            N
            備註
            */
        ];
    }

    /**
     * Execute the cell handle.
     *
     * @return array
     * @throws \Exception
     */
    protected function handle(): array
    {
        // You can use getInput function to get the value returned by validation rules
        // $this->getInput( Rules name )
        
        try {
            // DB Transaction begin
            DB::beginTransaction();

            $user = $this->getInput('User');

            if (TokenAuth::model() === get_class($user) || ! ($guard = TokenAuth::getAuthGuard($user))) {
                throw new ExceptionCode(ExceptionCode::USER_TYPE_NOT_SUPPORT);
            }

            $note = [
                'app_id' => $this->getInput('AppId'),
                'provider' => Janitor::getGuestType($this->controller()),
                'amount' => $this->getInput('Amount'),
                'name' => $this->getInput('ItemName'),
                'desc' => $this->getInput('ItemDesc'),
                'remark' => $this->getInput('Remark'),
            ];

            $order = $user->submitReceipt('billing', [
                'label' => $this->label,
                'content' => 'Billing request.',
                'note' => $note
            ]);

            $parameter = [];

            $parameter['DistributorId'] = $this->config('client_id');
            /*
            String(2)
            Y
            商店編號
            */
            
            $parameter['OrderBillNo'] = $order->order;
            /*
            String(50)
            Y
            商店交易編號
            */
            
            $parameter['TradeDate'] = $order->asLocalTime($order->created_at)->format('YmdHis');
            /*
            String(16)
            Y
            交易時間
            格式：
            YYYYMMddHHmmss
            */
    
            $parameter['Amount'] = $this->getInput('Amount');
            /*
            Integer
            Y
            金額
            */
            
            $parameter['Category'] = $this->category;
            /*
            Integer
            Y
            訂單種類
            1 超商代碼
            2 虛擬ATM
            3 信用卡
            4 代撥
            */
            // 當 Category 為 4 代撥時，需要下列參數
            if ($this->category === 4) {
    
                $parameter['BankCode'] = $this->config('bank_code');
                /*
                String(20)
                Y
                銀行代碼
                */
            
                $parameter['BranchCode'] = $this->config('branch_code');
                /*
                String(50)
                N
                分行代碼
                */
            
                $parameter['BankAccount'] = $this->config('bank_account');
                /*
                String(50)
                Y
                銀行帳號
                */
            
                $parameter['AccountName'] = $this->config('account_name');
                /*
                String(50)
                Y
                戶名
                */
            }
           
            $parameter['ItemName'] = $this->getInput('ItemName');
            /*
            String(50)
            N
            商品名稱
            */
            
            $parameter['ItemDesc'] = $this->getInput('ItemDesc');
            /*
            String(50)
            N
            商品描述
            */
            
            $parameter['Customer'] = $guard . ':' . $user->uid;
            /*
            String(50)
            N
            消費者編號或帳號
            */
            
            $parameter['Remark'] = $this->getInput('Remark');
            /*
            String(50)
            N
            備註
            */
            
            $parameter['NotifyUrl'] = $this->config('notify_url');
            /*
            String(200)
            Y
            完成通知網址
            */
            
            $parameter['PaymentUrl'] = $this->config('payment_url');
            /*
            String(200)
            Y
            取號通知網址
            */
            
            $parameter['ReturnUrl'] = $this->config('return_url');
            /*
            String(200)
            Y
            完成返回網址
            */
            
            $parameter['CustomCol'] = $guard . ':' . $user->uid;
            /*
            String(50)
            N
            自訂義欄位，原字回傳
            */
            
            $parameter['Signature'] = md5($this->config('client_id') . $parameter['OrderBillNo'] . $parameter['Amount'] . $this->config('client_secret')); 
            /*
            String
            Y
            簽名
            */
    
            $result = $this->httpSend($parameter);

            if ($result['success']) {
                DB::commit();
            } else {
                DB::rollback();
            }
            
            return $result;
        } catch (\Throwable $e) {
            DB::rollback();
            /* Return failure message */
            return $this->failure([
                'message' => $e->getMessage()
            ]);
            /* Throw error */
            // throw $e;
        }
    }

    /**
     * Http send.
     * 
     * @param array $data
     * 
     * @return array|null
     */
    private function httpSend($data): ?array
    {
        /* Request */
        $client = new \GuzzleHttp\Client();

        $response = $client->post(
            $this->config('api_url') . '/initDeposit',
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($data),
            ]
        );

        $body = $response->getBody();

        if ($error = json_decode((string) $body)) {
            return $this->failure([
                'message' => Lang::dict('janitor', 'data.' . Janitor::getGuestType($this->controller()) . '.error.' . $error->error, $error->content->msg)
            ]);
        } else {
            /* Return success message */
            return $this->success([
                'html' => (string) $body
            ]);
        }
    }
}