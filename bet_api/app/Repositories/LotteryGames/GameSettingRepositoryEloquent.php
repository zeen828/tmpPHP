<?php

namespace App\Repositories\LotteryGames;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LotteryGames\GameSettingRepository;
use App\Entities\LotteryGames\GameSetting;
use App\Validators\LotteryGames\GameSettingValidator;
use Carbon;

/**
 * Class GameSettingRepositoryEloquent.
 *
 * @package namespace App\Repositories\LotteryGames;
 */
class GameSettingRepositoryEloquent extends BaseRepository implements GameSettingRepository
{
    /**
     * Search Field Setting
     *
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
    ];

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\Presenters\LotteryGames\GameSettingPresenter";
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GameSetting::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GameSettingValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    /**
     * Get the game settings that need to be drawn today.(取得今日需要開獎的遊戲設定)
     *
     * @return void
     */
    public function getGameSettingsNeedDrawValid()
    {
        // Today week.(今天星期)
        $todayWeek = (Carbon::now()->dayOfWeek == 0)? '7' : (string) Carbon::now()->dayOfWeek;
        // $todayWeek = date('w');
        // PS:date (1 for Monday, 7 for Sunday)，Carbon(1 for Monday, 0 for Sunday)，0 is adjusted to 7
        // JSON_CONTAINS(`week`, '4')//mysql查詢JSON結構值
        return $this->model
            //->select('id', 'start_t', 'end_t', 'repeat', 'reservation')
            ->where('status', '1')
            //->whereRaw('JSON_CONTAINS(`week`, \'' . $todayWeek . '\')')
            ->whereJsonContains('week', [$todayWeek])// JSON是強型別,變數型別要注意
            ->get();
    }
}
