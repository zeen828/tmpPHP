<?php

namespace App\Entities\LotteryGames;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Libraries\Traits\Entity\Swap\TimeEquation;
use App\Libraries\Traits\Entity\Swap\Identity;

/**
 * Class GameDraw.
 *
 * @package namespace App\Entities\LotteryGames;
 */
class GameDraw extends Model implements Transformable
{
    use TransformableTrait;
    use TimeEquation;
    use Identity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lottery_game_draw';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'period',
        'ready_at',
        'draw_at',
        'start_at',
        'stop_at',
        'general_draw',
        'special_draw',
        'draw_rule_json',
        'bet_quantity',
        'bet_amount',
        'draw_quantity',
        'draw_amount',
        'draw_rate',
        'redeem',
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
    protected $dates = [
        'draw_at',
        'ready_at',
        'start_at',
        'stop_at',
    ];

    public function getMidAttribute(): ?string
    {
        return ($this->exists ? $this->tid : null);
    }

    /**
     * One to one game setting relationships.(一對一遊戲設定關聯)
     *
     * @return void
     */
    public function rGameSetting()
    {
        return $this->hasOne('App\Entities\LotteryGames\GameSetting', 'id', 'game_id');
    }
}
