<?php

namespace App\Console\Commands\Tests;

use Illuminate\Console\Command;
// Model
use App\Entities\LotteryGames\GameSetting;
use App\Entities\LotteryGames\GameDraw;
use App\Entities\LotteryGames\GameRule;
use App\Entities\LotteryGames\GameBet;
// Repository;
use App\Repositories\LotteryGames\GameSettingRepository;
use App\Repositories\LotteryGames\GameDrawRepository;
use App\Repositories\LotteryGames\GameRuleRepository;
use App\Repositories\LotteryGames\GameBetRepository;
// HTTP
use Illuminate\Support\Facades\Http;
// 開獎
use App\Libraries\LotteryGames\Lottery01\GameDraw as LibGameDraw;
use App\Libraries\LotteryGames\Lottery01\GameDrawRules as LibGameDrawRules;
// 單據
// use App\Entities\Jwt\Auth;
// use App\Entities\Member\Auth as MemberAuth;
// use DB;
// 交易
use App\Entities\Account\Gift;
use App\Entities\Account\Gold;
use App\Entities\Jwt\Auth;
use App\Entities\Member\Auth as MemberAuth;
use DB;
// 開發
Use App\Libraries\Traits\Entity\Swap\Identity;

class TestModelJob extends Command
{
    protected $settingR;
    protected $drawR;
    protected $ruleR;
    protected $betR;

    // use Identity;

    /**
     * The name and signature of the console command.
     *
     * php artisan tests:model
     * @var string
     */
    protected $signature = 'tests:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GameSettingRepository $settingR, GameDrawRepository $drawR, GameRuleRepository $ruleR, GameBetRepository $betR)
    {
        parent::__construct();

        $this->settingR = $settingR;
        $this->drawR = $drawR;
        $this->ruleR = $ruleR;
        $this->betR = $betR;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $testNo = $this->ask('Test number?(m:Menu list)');
        $this->info('[' . date('Y-m-d H:i:s') . '] START');

        switch ($testNo) {
            case 1:
                $this->info('Test [Model]');
                $findId = $this->ask('Query find id?');

                $this->info('GameSetting');
                $demo = GameSetting::find($findId);
                print_r($demo);

                $this->info('GameRule');
                $demo = GameRule::find($findId);
                print_r($demo);
                // print_r($demo->game);

                $this->info('GameDraw');
                $demo = GameDraw::find($findId);
                print_r($demo);
                // print_r($demo->game);

                $this->info('GameBet');
                $demo = GameBet::find($findId);
                print_r($demo);
                // print_r($demo->game);
                // print_r($demo->draw_period);
                // print_r($demo->rule);
                // 喚起物件
                $user = app($demo->user_type)->find($demo->user_id);
                var_dump($user);
                break;

            case 2:
                $this->info('Test [Repository + Criteria]');
                $findId = $this->ask('Query find id?');

                $this->info('GameSettingRepository');
                // 單筆
                $demo = $this->settingR->find($findId);
                // 增加標準查詢
                // $this->settingR->pushCriteria(app('App\Criteria\LotteryGames\GameDraw\IndexCriteria'));
                // $demo = $this->settingR->all();
                // 忽略標準查詢
                // $demo = $this->settingR->skipCriteria()->all();
                // 可以取代pushCriteria()->all()
                // $demo = $this->settingR->getByCriteria(new IndexCriteria());
                // 新增
                // $demo = $this->settingR->create([
                //     'name'=>'testa',
                //     'status'=>'0',
                // ]);
                // 更新
                // $demo = $this->settingR->update([
                //     'name'=>'testa112313',
                //     'status'=>'1',
                // ], 3);
                print_r($demo);

                $this->info('GameDrawRepository');
                $demo = $this->drawR->find($findId);
                // $this->drawR->pushCriteria(app('App\Criteria\LotteryGames\GameDraw\IndexCriteria'));
                // $this->drawR->pushCriteria(app('App\Criteria\LotteryGames\GameDraw\QueryHistoryCriteria'));
                // $demo = $this->drawR->all();
                print_r($demo);

                $this->info('GameRuleRepository');
                $demo = $this->ruleR->find($findId);
                // $this->ruleR->pushCriteria(app('App\Criteria\LotteryGames\GameDraw\IndexCriteria'));
                // $demo = $this->ruleR->all();
                print_r($demo);

                $this->info('GameBetRepository');
                $demo = $this->betR->find($findId);
                // $this->betR->pushCriteria(app('App\Criteria\LotteryGames\GameDraw\IndexCriteria'));
                // $demo = $this->betR->all();
                print_r($demo);
                break;

            case 3:
                $this->info('Test [HTTP]');

                $config = [
                    'ssl' => env('DOCKING_API_SSL'),
                    'domain' => env('DOCKING_API_DOMAIN'),
                ];
                // setup1 Client 登入
                $this->info('Setup 1');
                $apiUrl = sprintf('%s://%s/api/v1/auth/token', $config['ssl'], $config['domain']);
                $headerData = [
                    // 'Content-Type' => 'application/x-www-form-urlencoded',
                ];
                $formData = [
                    'client_id' => env('DOCKING_API_CLIENT_ID'),
                    'client_secret' => env('DOCKING_API_CLIENT_SECRET'),
                ];
                $response = Http::withHeaders($headerData)->post($apiUrl, $formData);
                if($response->failed()){
                    echo "Setup 1: error\n";
                    return false;
                }
                $client = $response->json();
                print_r($client);

                // setup2 user signature 登入
                $this->info('Setup 2');
                $apiUrl = sprintf('%s://%s/api/v1/auth/user/signature/login', $config['ssl'], $config['domain']);
                $headerData['Authorization'] = sprintf('Bearer %s', $client['data']['access_token']);
                $formData = [
                    'signature' => '4ccc68cb064f46fab83ac56858a27e27c3a4b2d8fd75e32508fa03fcdbf6fca819fced70',
                ];
                $response = Http::withHeaders($headerData)->post($apiUrl, $formData);
                if($response->failed()){
                    echo "Setup 2: error\n";
                    return false;
                }
                $userToken = $response->json();
                print_r($userToken);

                // setup3 user 資訊
                $this->info('Setup 3');
                $apiUrl = sprintf('%s://%s/api/v1/member/auth/me', $config['ssl'], $config['domain']);
                $headerData['Authorization'] = sprintf('Bearer %s', $userToken['data']['access_token']);
                $response = Http::withHeaders($headerData)->get($apiUrl);
                if($response->failed()){
                    echo "Setup 3: error\n";
                    // return false;
                }
                $userToken = $response->json();
                print_r($userToken);
                break;

            case 4:
                $apiUrl = 'https://reqbin.com/echo/get/json';
                $response = Http::get($apiUrl);
                if ($response->ok()) {
                    var_dump($response->body());
                }
                break;

            case 5:
                $resHeaderData = [
                    'content-type' => 'application/json',
                ];
                $resData = [
                    'success' => true,
                    'data' => [
                        'access_token' => 'test_token',
                        'expires_in' => '86400',
                    ]
                ];
                // 這個可以模擬你訪問的請求回傳指定內容
                Http::fake([
                    '*' => Http::response($resData, 200, $resHeaderData),
                ]);

                $apiUrl = 'https://reqbin.com/echo/post/json';
                $formData = [
                    'debug' => true,
                ];

                // 透過asForm()可改為application/x-www-form-urlencoded
                $response = Http::asForm()->post($apiUrl, $formData);
                print_r($response);
                if ($response->ok()) {
                    var_dump($response->body());
                }
                break;

            case 6:
                $this->info('Test [Game Deaw]');
                $gameId = $this->ask('Query game id?');

                $LGameDraw = new LibGameDraw();
                $gameSetting = $this->settingR->model()::find($gameId);
                if (empty($gameSetting)) {
                    return $response->success(['data' => 'error']);
                }
                $generalDrawArr = $LGameDraw->setGeneraDrawRule($gameSetting->general_data_json, $gameSetting->general_digits, $gameSetting->general_repeat);
                var_dump($generalDrawArr);
                $specialDrawArr = $LGameDraw->setSpecialDrawRule($gameSetting->special_data_json, $gameSetting->special_digits, $gameSetting->special_repeat);
                var_dump($specialDrawArr);
                break;

            case 7:
                $this->info('Test [Trade - Add]');
                $currencyID = $this->ask('set currency?(gold/gift)');
                $memberId = $this->ask('Add point member id?');
                $clientID = $this->ask('Send poind client id?');
                $point = $this->ask('Add point?');

                // $memberId = 2;
                // $clientID = 1;
                // // $point = 100000000.130;
                // $point = 3.130;

                $user = MemberAuth::find($memberId);
                print_r($user);
                if ($currencyID == 'gift') {
                    $account = $user->tradeAccount(Gift::class);
                } else {
                    $account = $user->tradeAccount(Gold::class);
                }
                // $account = $user->tradeAccount(Gift::class);
                // $account = $user->tradeAccount(Gold::class);
                $target = Auth::find($clientID);
                print_r($target);
                // DB Transaction begin
                DB::beginTransaction();
                $item = $account->where('id', $account->id)->lockForUpdate()->first();
                $trade = $item->beginTradeAmount($target);
                // Amount of income by trade
                $order = $trade->amountOfIncome($point, [
                    'label' => 'TEST ADD',
                    'content' => 'INCOME',
                    'note' => array(
                        'test'=>'test'
                    )
                ]);
                DB::commit();
                break;

            case 8:
                $this->info('Test [Trade - Del]');
                $currencyID = $this->ask('set currency?');
                $memberId = $this->ask('Del point member id?');
                $clientID = $this->ask('Deduction poind client id?');
                $point = $this->ask('Del point?');

                // $memberId = 11;
                // $clientID = 1;
                // $point = 10.130;
                
                $user = MemberAuth::find($memberId);
                if ($currencyID == 'gift') {
                    $account = $user->tradeAccount(Gift::class);
                } else {
                    $account = $user->tradeAccount(Gold::class);
                }
                // $account = $user->tradeAccount(Gift::class);
                // $account = $user->tradeAccount(Gold::class);
                $target = Auth::find($clientID);
                // DB Transaction begin
                DB::beginTransaction();
                $item = $account->where('id', $account->id)->lockForUpdate()->first();
                $trade = $item->beginTradeAmount($target);
                // Amount of income by trade
                $order = $trade->amountOfExpenses($point, [
                    'label' => 'TEST DEL',
                    'content' => 'EXPENSES',
                    'note' => array(
                        'test'=>'test'
                    )
                ]);
                DB::commit();
                break;

            case 9:
                $this->info('Dev Test');

                // $this->info('多型工具');
                // $demo = GameSetting::find(1);
                // print_r($demo);
                // $className = get_class($demo);// 獲取物件名稱
                // var_dump($className);
                // $classRe = app($className);// 重新呼叫CLASS
                // var_dump($classRe);
                // $demo = $classRe->find(1);
                // print_r($demo);
                break;

            case 10:
                $this->info('Test [ID 轉換 雜湊ID]');
                
                $id = 28;
                var_dump($id);
                $ids = [8, 28];
                var_dump($ids);

                $tid = $this->asPrimaryTid($id);// 轉換雜湊ID
                var_dump($tid);
                // string(8) "28864208"
                $rid = $this->asPrimaryId($tid);// 轉回ID
                var_dump($rid);
                // int(28)

                $tids = $this->asPrimaryTids($ids);// 轉換雜湊ID
                var_dump($tids);
                // array(2) {
                //     [0]=>
                //     string(7) "8326291"
                //     [1]=>
                //     string(8) "28864208"
                // }
                $rids = $this->asPrimaryIds($tids);
                var_dump($rids);
                // array(2) {
                //     [0]=>
                //     int(8)
                //     [1]=>
                //     int(28)
                // }
                break;

            case 11:
                $this->info('Test Receipt');// 單據
                $item = app(Auth::class);
                // 2：查詢定義列表
                $formdefines = $item->getReceiptFormdefines();
                var_dump($formdefines);
                var_dump(current($formdefines));
                // 3：退貨表格代碼編號
                $code = $item->getReceiptFormdefineCode(current($formdefines));
                var_dump($code);
                // 4：單據模型返回
                $editorModles = $item->takeReceiptFormdefineEditors(current($formdefines));
                var_dump($editorModles);
                // 5：檢查定義類型是否允許
                $status = $item->isReceiptFormdefineAllowed(current($formdefines));
                var_dump($status);
                // 6：收穫來源模型
                $sourceables = $item->getReceiptSourceables();
                var_dump($sourceables);
                // 7：
                $type = $item->getReceiptSourceableType(Auth::class);
                var_dump($type);
                // 8：
                $model = $item->getReceiptSourceableModel($type);
                var_dump($model);
                // 9：
                $code = $item->getReceiptSourceableCode(Auth::class);
                var_dump($code);
                // 10：
                $status = $item->isReceiptSourceableAllowed(Auth::class);
                var_dump($status);
                // 11：
                $columns = [
                    'type',
                    'description'
                ];
                $currencys = $item->formTypes($columns);
                var_dump($currencys);
                break;

            case 12:
                $item = app(MemberAuth::class);
                $item2 = app(Auth::class);
                $user = MemberAuth::find(1);
                $system = Auth::find(1);// Client
                // 3：
                // $forms = $item->heldForms();
                // var_dump($forms);
                // 4：
                // $columns = [
                //     'type',
                //     'description'
                // ];
                // $forms = $item->heldCFormTypes($columns);
                // var_dump($forms);
                // 5：
                // $order = $user->submitReceipt('billing', [
                //     'label' => 'member-store',
                //     'content' => 'Billing request.',
                //     'note' => 'Custom notes 1'
                // ]);
                // var_dump($order);
                // 6：
                // DB Transaction begin
                DB::beginTransaction();
                $order = $user->submitReceipt('billing', [
                    'label' => 'member-store',
                    'content' => 'Billing request.',
                    'note' => 'Custom notes 1'
                ]);
                echo 'get_class:', get_class($order);
                $order = $order->where('id', $order->id)->lockForUpdate()->first();
                $order2 = $user->submitReceipt('deposit', [
                    'label' => 'system-verify',
                    'content' => 'Deposit finish.',
                    'note' => 'Custom notes 2'
                ], $order);
                // Synchronization update main $order status field
                DB::commit();
                // Related order
                // $order->order = $order2->order;
                // $order->created_at = $order2->created_at;
                var_dump($order2);
                break;

            default:
                $this->info('Menu list number');
                $this->info('1. Model');
                $this->info('2. Repository + Criteria');
                $this->info('3. HTTP(guzzle)');
                $this->info('4. HTTP(guzzle)');
                $this->info('5. HTTP(guzzle)');
                $this->info('6. Game Deaw');
                $this->info('7. Trade add point');
                $this->info('8. Trade del point');
                $this->info('9. model model');
                $this->info('10. user id <=> uid');
                $this->info('11. Receipt Setting');
                $this->info('12. Receipt');
                break;
        }

        $this->info('[' . date('Y-m-d H:i:s') . '] END');
        return 0;
    }
}
