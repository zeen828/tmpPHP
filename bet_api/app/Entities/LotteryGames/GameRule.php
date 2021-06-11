<?php

namespace App\Entities\LotteryGames;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Libraries\Traits\Entity\Swap\TimeEquation;

/**
 * Class GameRule.
 *
 * @package namespace App\Entities\LotteryGames;
 */
class GameRule extends Model implements Transformable
{
    use TransformableTrait;
    use TimeEquation;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lottery_game_rule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'type_id',
        'name',
        'description',
        'rule_json',
        'bet_json',
        'odds',
        'sort',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * The other attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * One to one game setting relationships.(一對一遊戲設定關聯)
     *
     * @return void
     */
    public function rGameSetting()
    {
        return $this->hasOne('App\Entities\LotteryGames\GameSetting', 'id', 'game_id');
    }

    /**
     * One to one game setting relationships.(一對一遊戲設定關聯)
     *
     * @return void
     */
    public function rGameRuleType()
    {
        return $this->hasOne('App\Entities\LotteryGames\GameRuleType', 'id', 'type_id');
    }
}
