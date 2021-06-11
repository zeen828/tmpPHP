<?php

namespace App\Repositories\LotteryGames;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LotteryGames\GameRuleTypeRepository;
use App\Entities\LotteryGames\GameRuleType;
use App\Validators\LotteryGames\GameRuleTypeValidator;

/**
 * Class GameRuleTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories\LotteryGames;
 */
class GameRuleTypeRepositoryEloquent extends BaseRepository implements GameRuleTypeRepository
{
    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\Presenters\LotteryGames\GameRuleTypePresenter";
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GameRuleType::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GameRuleTypeValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
