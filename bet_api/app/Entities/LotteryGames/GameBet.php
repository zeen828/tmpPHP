<?php

namespace App\Entities\LotteryGames;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Libraries\Traits\Entity\Swap\TimeEquation;

/**
 * Class GameBet.
 *
 * @package namespace App\Entities\LotteryGames;
 */
class GameBet extends Model implements Transformable
{
    use TransformableTrait;
    use TimeEquation;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lottery_game_bet';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_type',
        'source_id',
        'user_type',
        'user_id',
        'game_id',
        'draw_id',
        'period',
        'rule_id',
        'value',
        'quantity',
        'amount',
        'profit',
        'win_sys',
        'win_user',
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
     * One to one game draw relationships.(一對一遊戲開獎關聯)
     *
     * @return void
     */
    public function rGameDraw()
    {
        return $this->hasOne('App\Entities\LotteryGames\GameDraw', 'id', 'draw_id');
    }

    /**
     * One to one game rule relationships.(一對一遊戲規則關聯)
     *
     * @return void
     */
    public function rGameRule()
    {
        return $this->hasOne('App\Entities\LotteryGames\GameRule', 'id', 'rule_id');
    }
}
