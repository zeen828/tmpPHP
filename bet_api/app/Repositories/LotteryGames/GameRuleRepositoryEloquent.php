<?php

namespace App\Repositories\LotteryGames;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LotteryGames\GameRuleRepository;
use App\Entities\LotteryGames\GameRule;
use App\Validators\LotteryGames\GameRuleValidator;

/**
 * Class GameRuleRepositoryEloquent.
 *
 * @package namespace App\Repositories\LotteryGames;
 */
class GameRuleRepositoryEloquent extends BaseRepository implements GameRuleRepository
{
    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\Presenters\LotteryGames\GameRulePresenter";
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GameRule::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GameRuleValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
