<?php

namespace App\Http\Controllers\LotteryGames;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LotteryGames\GameDrawCreateRequest;
use App\Http\Requests\LotteryGames\GameDrawUpdateRequest;
use App\Http\Responses\LotteryGames\GameDrawCreateResponse;
use App\Http\Responses\LotteryGames\GameDrawUpdateResponse;
use App\Exceptions\LotteryGames\GameDrawExceptionCode as ExceptionCode;
use App\Repositories\LotteryGames\GameDrawRepository;
use App\Validators\LotteryGames\GameDrawValidator;

use App\Repositories\LotteryGames\GameSettingRepository;
use App\Exceptions\LotteryGames\GameSettingExceptionCode;
use App\Repositories\LotteryGames\GameRuleRepository;
use App\Repositories\LotteryGames\GameBetRepository;
use App\Libraries\LotteryGames\Lottery01\GameDrawRules;

/**
 * @group
 *
 * Game Lottery / Draw
 *
 * @package namespace App\Http\Controllers\LotteryGames;
 */
class GameDrawController extends Controller
{
    /**
     * @var GameDrawRepository
     */
    protected $repository;

    /**
     * @var GameDrawValidator
     */
    protected $validator;

    /**
     * GameDrawController constructor.
     *
     * @param GameDrawRepository $repository
     * @param GameDrawValidator $validator
     */
    public function __construct(GameDrawRepository $repository, GameDrawValidator $validator)
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
     * mid | STR | Id
     * game | STR | Lottery game name
     * period | STR | 期數
     * draw_at | STR | 開獎時間
     * general_draw | STR | 一般號
     * special_draw | STR | 特別號
     * bet_quantity | STR | 投注數量
     * bet_amount | STR | 投注金額
     * draw_quantity | STR | 中獎數量
     * draw_amount | STR | 中獎金額
     * draw_rate | STR | 中獎率
     * status | STR | Status
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
     *             "mid": "1294583",
     *             "game": "北京賽車TEST",
     *             "period": "2020123000001",
     *             "draw_at": "2020-12-30 06:35:00",
     *             "general_draw": "10,01,07,06,03,09,05,04,08,02",
     *             "special_draw": "",
     *             "bet_quantity": 0,
     *             "bet_amount": "0.000",
     *             "draw_quantity": 8,
     *             "draw_amount": "0.000",
     *             "draw_rate": "0.00",
     *             "status": true
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
     * @param int $gameId
     * @param GameDrawCreateRequest $request
     * @param GameDrawCreateResponse $response
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminList($gameId, GameDrawCreateRequest $request, GameDrawCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameDraw\AdminCriteria'));

        $gameDraws = $this->repository->paginate($perPage);

        return $response->success($gameDraws);
    }

    /**
     * Admin Reset Draw
     * 
     * Administrator reset draw item.
     *
     * @param int $gameId
     * @param int $id
     * @param GameDrawUpdateRequest $request
     * @param GameDrawUpdateResponse $response
     * @param GameSettingRepository $settingRrepository
     * @param GameRuleRepository $ruleRrepository
     * @param GameBetRepository $betRrepository
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminRedraw($gameId, $id, GameDrawUpdateRequest $request, GameDrawUpdateResponse $response, GameSettingRepository $settingRrepository, GameRuleRepository $ruleRrepository, GameBetRepository $betRrepository)
    {
        // 取開獎紀錄
        $gameDraw = $this->repository->model()::find($id);

        // 開獎Lib
        //$LibGameDraw = new GameDraw();
        $LibGameDrawRule = new GameDrawRules();

        // 統計
        $bet_quantity = $betRrepository->model()::where([
            'game_id'=>$gameId,
            'draw_id'=>$id,
            'status'=>'1',
        ])->sum('quantity');
        $bet_amount = $betRrepository->model()::where([
            'game_id'=>$gameId,
            'draw_id'=>$id,
            'status'=>'1',
        ])->sum('amount');

        // 取遊戲設定
        $gameSetting = $settingRrepository->model()::find($gameId);
        if (empty($gameSetting)) {
            // Game setting that does not exist
            throw new GameSettingExceptionCode(GameSettingExceptionCode::NOT_EXIST);
        }

        $recount = 0;
        do {
            // 一般號碼開獎
            $generalOpenArr = $LibGameDrawRule->setGeneraDrawRule($gameSetting->general_data_json, $gameSetting->general_digits, $gameSetting->general_repeat);
            // $generalOpenArr = ['08', '01', '03', '06', '02', '05', '10', '09', '07', '04'];
            // 特別區開獎
            $specialOpenArr = $LibGameDrawRule->setSpecialDrawRule($gameSetting->special_data_json, $gameSetting->special_digits, $gameSetting->special_repeat);

            // 取遊戲規則
            $gameRules = $ruleRrepository->model()::where(['game_id'=>$gameId, 'status'=>'1'])->orderBy('sort', 'asc')->get();
            $openRules = [];// 開獎容器
            if(!$gameRules->isEmpty()){
                // 開獎規則Lib
                $LibGameDrawRule->setDarwCode($generalOpenArr, $specialOpenArr);
                foreach ($gameRules as $val) {
                    // 判斷規則
                    $answer = $LibGameDrawRule->lottery01Rule($val->type_id, $val->rule_json);
                    // 判斷是否又回傳值
                    if (isset($answer['codeVal'])) {
                        $openRules[$val->id] = array(
                            'ruleId' => $val->id,
                            'typeId' => $val->type_id,
                            'name' => $val->name,
                            'codeVal' => $answer['codeVal'],
                        );
                    }
                    unset($answer);
                    unset($val);
                }
            }
            $draw_rule_json = json_encode($openRules);

            // 統計開獎
            $betRrepository->model()::where([
                'game_id'=>$gameId,
                'draw_id'=>$id,
                'status'=>'1',
            ])->update([
                'win_sys'=>'0',
                'win_user'=>'0',
            ]);
            foreach ($openRules as $val) {
                $betRrepository->model()::where([
                    'game_id'=>$gameId,
                    'draw_id'=>$id,
                    'rule_id'=>$val['ruleId'],
                    'value'=>$val['codeVal'],
                    'status'=>'1',
                ])->update([
                    'win_sys'=>'1',
                    'win_user'=>'0',
                ]);
            }

            // 算獲獎機率
            $draw_quantity = $betRrepository->model()::where([
                'game_id'=>$gameId,
                'draw_id'=>$id,
                'win_sys'=>'1',
                'status'=>'1',
            ])->sum('quantity');
            $draw_amount = $betRrepository->model()::where([
                'game_id'=>$gameId,
                'draw_id'=>$id,
                'win_sys'=>'1',
                'status'=>'1',
            ])->sum('amount');
            if(!empty($draw_quantity) && !empty($bet_quantity)){
                $draw_rate = sprintf('%.2f', $draw_quantity / $bet_quantity * 100);
            } else {
                $draw_rate = sprintf('%.2f', 0);
            }

            $recount++;
        } while($draw_rate >= $gameSetting->win_rate && $recount <= 10);

        // 新開獎
        $gameDraw->update([
            'general_draw' => implode(',', $generalOpenArr),
            'special_draw' => implode(',', $specialOpenArr),
            'draw_rule_json' => $draw_rule_json,
            'bet_quantity' => $bet_quantity,
            'bet_amount' => $bet_amount,
            'draw_quantity' => $draw_quantity,
            'draw_amount' => $draw_amount,
            'draw_rate' => $draw_rate,
        ]);

        return $response->success(['data' => $gameDraw]);
    }

    /**
     * User query draw history
     *
     * ded
     *
     * ### Response Body
     *
     * success : true
     *
     * data :
     *
     * Parameter | Type | Description
     * --------- | ------- | ------- | -----------
     * id | STR | Lottery game draw id
     * game_id | STR | Lottery game id
     * period | STR | Lottery game draw period
     * draw_at | STR | Lottery game draw datetime
     * general_draw | STR | Lottery game draw
     * special_draw | STR | Lottery game draw
     * status | STR | Lottery game draw status ( success, failure )
     * created_at | STR | Datetime when the SMS was sent
     * updated_at | STR | Datetime when the log was updated
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
     * @queryParam period Lottery game draw period Example: 2020010100001
     * @queryParam start Start range of query creation date Example: 2018-10-01
     * @queryParam end End range of query creation date Example: 2020-10-30
     * @queryParam page required Page number Example: 1
     * @queryParam rows Per page rows defaults to 15 Example: 15
     *
     * @response
     * {
     *     "success": true,
     *     "data": [
     *         {
     *             "id": 20,
     *             "game_id": 1,
     *             "period": "2020122200020",
     *             "draw_at": "2020-12-22 08:10:00",
     *             "general_draw": "09,04,05,02,03,10,01,06,07,08",
     *             "special_draw": "",
     *             "status": true,
     *             "created_at": "2020-12-22 14:30:55",
     *             "updated_at": "2020-12-22 14:43:21"
     *         }
     *     ],
     *     "meta": {
     *         "pagination": {
     *             "total": 1,
     *             "count": 1,
     *             "per_page": 15,
     *             "current_page": 1,
     *             "total_pages": 1,
     *             "links": {}
     *         }
     *     }
     * }
     *
     * @param integer $gameId
     * @param GameDrawCreateRequest $request
     * @param GameDrawCreateResponse $response
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryHistory($gameId, GameDrawCreateRequest $request, GameDrawCreateResponse $response)
    {
        $perPage = $request->input('rows', 15);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameDraw\UserCriteria'));
        $this->repository->pushCriteria(app('App\Criteria\LotteryGames\GameDraw\QueryHistoryCriteria'));

        $gameDraws = $this->repository->paginate($perPage);

        return $response->success($gameDraws);
    }
}