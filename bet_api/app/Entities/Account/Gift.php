<?php

namespace App\Entities\Account;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Libraries\Traits\Entity\Swap\TimeEquation;
use App\Libraries\Traits\Entity\Swap\Identity;
use App\Libraries\Traits\Entity\Trade\Currency;

/**
 * Class Gift.
 *
 * @package App\Entities\Account
 */
class Gift extends Model implements Transformable
{
    use TransformableTrait;
    use TimeEquation;
    use Identity;
    use Currency;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gift_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'holderable_type',
        'holderable_id',
        'amount',
        'code',
        'created_at',
        'updated_at'
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
    protected $casts = [];

    /**
     * The other attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    public $timestamps = false;
}