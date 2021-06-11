<?php

namespace App\Entities\LotteryGames;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Libraries\Traits\Entity\Swap\TimeEquation;

/**
 * Class GameSetting.
 *
 * @package namespace App\Entities\LotteryGames;
 */
class GameSetting extends Model implements Transformable
{
    use TransformableTrait;
    use TimeEquation;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lottery_game_setting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'general_data_json',
        'general_digits',
        'general_repeat',
        'special_data_json',
        'special_digits',
        'special_repeat',
        'week',
        'start_t',
        'end_t',
        'stop_enter',
        'repeat',
        'reservation',
        'win_rate',
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
        'general_repeat' => 'boolean',
        'special_repeat' => 'boolean',
        'reservation' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * The other attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
}
