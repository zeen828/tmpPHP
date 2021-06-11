<?php

namespace App\Http\Controllers\LotteryGames;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LotteryGames\GameBetCreateRequest;
use App\Http\Requests\LotteryGames\GameBetUpdateRequest;
use App\Http\Responses\LotteryGames\GameBetCreateResponse;
use App\Http\Responses\LotteryGames\GameBetUpdateResponse;
use App\Exceptions\LotteryGames\GameBetExceptionCode as ExceptionCode;
use App\Repositories\LotteryGames\GameBetRepository;
use App\Validators\LotteryGames\GameBetValidator;
use TokenAuth;
use App\Exceptions\Jwt\AuthExceptionCode;
use App\Entities\Account\Gift;
use App\Entities\Account\Gold;
use DB;
use App\Repositories\LotteryGames\GameDrawRepository;
use App\Repositories\LotteryGames\GameRuleRepository;
use Carbon;

/**
 * @group
 *
 * Game Lottery / Bet
 *
 * @package namespace App\Http\Controllers\LotteryGames;
 */
class GameBetController extends Controller
{
    /**
     * @var GameBetRepository
     */
    protected $repository;

    /**
     * @var GameBetValidator
     */
    protected $validator;

    /**
     * GameBetController constructor.
     *
     * @param GameBetRepository $repository
     * @param GameBetValidator $validator
     */
    public function __construct(GameBetRepository $repository, GameBetValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Admin list
     *
     * Administrator query list.
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * game | STR | 投注遊戲名稱
     * period | STR | 投注期數
     * rule | STR | 投注玩法項目
     * value | STR | 投注項目值
     * quantity | STR | 投注數量
     * amount | STR | 投注金額
     * profit | STR | 勝利預估金額
     * win_user | STR | 用戶輸贏
     * status | STR | 狀態
     * created_at | STR | 下注時間
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
     * @queryParam search search keywork. Example: 名次猜車號
     * @queryParam orderBy Sort order field. Example: id,status
     * @queryParam sortedBy Sort order. Example: asc,desc
     * @queryParam page required Page number. Example: 1
     * @queryParam rows Per page rows defaults to 15. Example: 15
     *
     * @response
     * {
     *     "success": true,
     *     "data": [
     *         {
     *             "game": "北京賽車TEST",
     *             "period": "2020123000001",
     *             "rule": "冠軍車號edit",
     *             "value": "01",
     *             "quantity": 1,
     *             "amount": "10.000",
     *             "profit": "19.750",
     *             "win_user": 0,
     *             "status": true,
     *             "created_at": "2021-02-09 17:53:37"
     *         }
     *     ],
     *     "meta": {
     *         "pagination": {
     *             "total": 6,
     *             "count": 1,
     *             "per_page": 1,
     *             "current_page": 1,
     *             "total_pages": 6
     *         }
     *     }
     * }
     * 
     * @param [type] $gameId
     * @param GameBetCreateRequest $request
     * @param GameBetCreateResponse $response
     * @return void
     */
    public function adminList($gameId, GameBetCreateRequest $request, GameBetCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameBet\AdminCriteria'));

        $gameBets = $this->repository->paginate($perPage);

        return $response->success($gameBets);
    }

    /**
     * User query record history
     *
     * @param [type] $gameId
     * @param GameBetCreateRequest $request
     * @param GameBetCreateResponse $response
     * @return void
     */
    public function queryRecord($gameId, GameBetCreateRequest $request, GameBetCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameBet\UserCriteria'));
        // $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameBet\QueryRecordCriteria'));

        $gameBets = $this->repository->paginate($perPage);

        return $response->success($gameBets);
    }

    /**
     * User bet item's
     *
     * @param [type] $gameId
     * @param GameBetCreateRequest $request
     * @param GameBetCreateResponse $response
     * @param GameDrawRepository $drawRepository
     * @param GameRuleRepository $ruleRepository
     * @return void
     */
    public function betOrders($gameId, GameBetCreateRequest $request, GameBetCreateResponse $response, GameDrawRepository $drawRepository, GameRuleRepository $ruleRepository)
    {
        /* Register */
        $credentials = $request->only([
            'rule_id',
            'value',
            'amount',
        ]);

        // print_r($credentials);
        if (count($credentials['amount']) != count($credentials['rule_id']) || count($credentials['amount']) != count($credentials['value'])) {
            // echo '數量不對錯誤例外退出';
        }
        // 下注總額(陣列加總)
        $total_amount = array_sum($credentials['amount']);

        /* Get Member User */
        $user = TokenAuth::getUser();
        $this->repository->refreshtUserData();
        if (empty($user)) {
            throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
        }
        $delay = $user->delay;
        //$delay = 60;

        /* Query currency point */
        $point = $this->repository->queryUserPoint();
        // print_r($point);
        // exit();
        if ((empty($point['gift']) && empty($point['gold'])) || ($point['total'] < $total_amount)) {
            // 點數不足
            // return $response->success(['data'=>$point]);
            // exit();
            throw new ExceptionCode(ExceptionCode::NOT_ENOUGH_POINT);
        }

        /* Get Game Rule list */
        $rulesArr = [];
        $rules = $ruleRepository->model()::where(['game_id' => $gameId, 'status' =>'1'])->whereIn('id', $credentials['rule_id'])->get();
        if ($rules->isEmpty()) {
            // 沒資料例外處理
            throw new ExceptionCode(ExceptionCode::WRONG_BET_VALUE);
        }
        foreach ($rules as $val) {
            $rulesArr[$val->id] = [
                'id' => $val->id,
                'bet_json' => $val->bet_json,
                'odds' => $val->odds,
            ];
        }

        /* User play game dely bet */
        $timeZone  = request()->header('x-timezone')? request()->header('x-timezone') : 'UTC';
        $nowUAt = Carbon::now($timeZone)->addSeconds($delay)->setTimezone('UTC');
        /* 要下注的開獎期 - model - 統計要做操作 */
        $draw = $drawRepository->model()::where(['game_id' => $gameId, ['draw_at', '>=', $nowUAt], ['stop_at', '>=', $nowUAt], 'redeem' => '0', 'status' =>'1'])->orderBy('draw_at', 'asc')->first();
        if (empty($draw)) {
            // Cannot bet today(今天已無法下注)
            throw new ExceptionCode(ExceptionCode::CANNOT_BET_TODAY);
        }
        // darw rule
        $drawRuleArr = json_decode($draw->draw_rule_json, true);

        for ($i = 0;$i < count($credentials['amount']);$i++) {
            $save = [

            ];
        }

        // 多筆迴圈
        DB::beginTransaction();
        // $bets = [];
        for ($i = 0;$i < count($credentials['amount']);$i++) {
            $rule_id = $credentials['rule_id'][$i];
            $value = $credentials['value'][$i];
            $amount = $credentials['amount'][$i];

            // 檢查下注值正確性
            // $betArr = json_decode($rule->bet_json, true);
            $betArr = json_decode($rulesArr[$rule_id]['bet_json'], true);
            if(empty($betArr) || !isset($betArr[$value])){
                // Wrong bet value(投注值錯誤)
                throw new ExceptionCode(ExceptionCode::WRONG_BET_VALUE);
            }

            /* Game bet and deduction */
            // 統計
            $draw->increment('bet_quantity');
            $draw->increment('bet_amount', $amount);
            if(isset($drawRuleArr[$rule_id]) && $drawRuleArr[$rule_id]['codeVal'] == $value){
                // 中獎
                $draw->increment('draw_quantity');
                $draw->increment('draw_amount', $amount);
                $win_sys = 2;// 0:未開獎1:未中獎2:中獎
            } else {
                $win_sys = 1;// 0:未開獎1:未中獎2:中獎
            }

            // 勝率統計
            if (!empty($draw->draw_quantity) && !empty($draw->bet_quantity)) {
                $draw->draw_rate = ($draw->draw_quantity / $draw->bet_quantity) * 100;
            }
            $draw->save();

            // Lottery Game Bet
            // $profit = $amount * $rule->odds;
            $profit = $amount * $rulesArr[$rule_id]['odds'];
            $bet = $this->repository->lotteryGameBet($gameId, $draw->id, $draw->period, $rule_id, $value, $amount, $profit, $win_sys);
            // $bets[] = $bet;
        }
        // Deduction
        $this->repository->betDeduction($bet->id, $total_amount);
        DB::commit();
        return $response->success(['data'=>null]);
    }

    /**
     * User bet item
     *
     * @param [type] $gameId
     * @param GameBetCreateRequest $request
     * @param GameBetCreateResponse $response
     * @param GameDrawRepository $drawRepository
     * @param GameRuleRepository $ruleRepository
     * @return void
     */
    public function betOrder($gameId, GameBetCreateRequest $request, GameBetCreateResponse $response, GameDrawRepository $drawRepository, GameRuleRepository $ruleRepository)
    {
        /* Register */
        $credentials = $request->only([
            'rule_id',
            'value',
            'amount',
        ]);

        /* Get Member User */
        $user = TokenAuth::getUser();
        $this->repository->refreshtUserData();
        if (empty($user)) {
            throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
        }
        $delay = $user->delay;
        //$delay = 60;

        /* Query currency point */
        $point = $this->repository->queryUserPoint();
        if ((empty($point['gift']) && empty($point['gold'])) || ($point['total'] < $credentials['amount'])) {
            // 點數不足
            throw new ExceptionCode(ExceptionCode::NOT_ENOUGH_POINT);
        }

        /* Game Rule */
        $rule = $ruleRepository->model()::where(['game_id' => $gameId, 'status' =>'1'])->find($credentials['rule_id']);
        if (empty($rule)) {
            // Wrong bet value(投注值錯誤)
            throw new ExceptionCode(ExceptionCode::WRONG_BET_VALUE);
        }
        // 檢查下注值正確性
        $betArr = json_decode($rule->bet_json, true);
        if(empty($betArr) || !isset($betArr[$credentials['value']])){
            // Wrong bet value(投注值錯誤)
            throw new ExceptionCode(ExceptionCode::WRONG_BET_VALUE);
        }

        /* User play game dely bet */
        $timeZone  = request()->header('x-timezone')? request()->header('x-timezone') : 'UTC';
        $nowUAt = Carbon::now($timeZone)->addSeconds($delay)->setTimezone('UTC');
        /* 要下注的開獎期 - model - 統計要做操作 */
        $draw = $drawRepository->model()::where(['game_id' => $gameId, ['draw_at', '>=', $nowUAt], ['stop_at', '>=', $nowUAt], 'redeem' => '0', 'status' =>'1'])->orderBy('draw_at', 'asc')->first();
        if (empty($draw)) {
            // Cannot bet today(今天已無法下注)
            throw new ExceptionCode(ExceptionCode::CANNOT_BET_TODAY);
        }
        // darw rule
        $drawRuleArr = json_decode($draw->draw_rule_json, true);

        /* Game bet and deduction */
        DB::beginTransaction();
            // 統計
            $draw->increment('bet_quantity');
            $draw->increment('bet_amount', $credentials['amount']);
            if(isset($drawRuleArr[$credentials['rule_id']]) && $drawRuleArr[$credentials['rule_id']]['codeVal'] == $credentials['value']){
                // 中獎
                $draw->increment('draw_quantity');
                $draw->increment('draw_amount', $credentials['amount']);
                $win_sys = 2;// 0:未開獎1:未中獎2:中獎
            } else {
                $win_sys = 1;// 0:未開獎1:未中獎2:中獎
            }

            // 勝率統計
            if (!empty($draw->draw_quantity) && !empty($draw->bet_quantity)) {
                $draw->draw_rate = ($draw->draw_quantity / $draw->bet_quantity) * 100;
            }
            $draw->save();

            // Lottery Game Bet
            $profit = $credentials['amount'] * $rule->odds;
            $bet = $this->repository->lotteryGameBet($gameId, $draw->id, $draw->period, $credentials['rule_id'], $credentials['value'], $credentials['amount'], $profit, $win_sys);

            // Deduction
            $this->repository->betDeduction($bet->id, $credentials['amount']);

        DB::commit();
        return $response->success(['data'=>$bet]);
    }
}