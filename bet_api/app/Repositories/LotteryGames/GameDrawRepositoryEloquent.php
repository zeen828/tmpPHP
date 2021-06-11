<?php

namespace App\Repositories\LotteryGames;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LotteryGames\GameDrawRepository;
use App\Entities\LotteryGames\GameDraw;
use App\Validators\LotteryGames\GameDrawValidator;

/**
 * Class GameDrawRepositoryEloquent.
 *
 * @package namespace App\Repositories\LotteryGames;
 */
class GameDrawRepositoryEloquent extends BaseRepository implements GameDrawRepository
{
    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\Presenters\LotteryGames\GameDrawPresenter";
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GameDraw::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GameDrawValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    /**
     * Create a unique game draw period.(建立唯一的遊戲開獎期數)
     *
     * @param integer $gameId 遊戲ID
     * @param integer $period 彩票期號
     * @param string $drawAt 開獎時間
     * @param string $readyAt 準備開獎時間
     * @return void
     */
    public function createOnlyDrawPeriod($gameId, $period, $drawAt, $readyAt, $startAt, $stopAt)
    {
        if (! $this->model->where('game_id', $gameId)->where('period', $period)->where('status', '1')->first()) {
            // Create a list of today's draws.(建立今天開獎項目清單)
            //$this->model->create(
            $this->create(
                [
                    'game_id' => $gameId,
                    'period' => $period,
                    'draw_at' => $drawAt,
                    'ready_at' => $readyAt,
                    'start_at' => $startAt,
                    'stop_at' => $stopAt,
                    'status' => '1',
                ]
            );
        }
    }

    public function getNeedDrawPeriod()
    {
        return $this->model
            ->with('rGameSetting')
            ->select('id', 'game_id', 'general_draw', 'special_draw', 'draw_rule_json')
            ->whereRaw('ready_at <= NOW()')
            ->whereNull('general_draw')
            ->where('status', '1')
            ->get();
    }
}
