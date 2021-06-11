<?php

namespace App\Entities\Admin;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Libraries\Traits\Entity\Auth\JWT;
use App\Libraries\Traits\Entity\Log\DataActivity;
use App\Libraries\Traits\Entity\Swap\TimeEquation;
use App\Libraries\Traits\Entity\Swap\Identity;
use App\Exceptions\Admin\AuthExceptionCode as ExceptionCode;
use App\Libraries\Traits\Entity\Column\Authority;
use Illuminate\Notifications\Notifiable;
use App\Libraries\Traits\Entity\Trade\Auth as TradeAuth;
use App\Libraries\Traits\Entity\Receipt\Auth as ReceiptAuth;

/**
 * Class Auth.
 *
 * @package App\Entities\Admin
 */
class Auth extends Authenticatable implements Transformable, JWTSubject
{
    use TransformableTrait;
    use JWT;
    use DataActivity;
    use TimeEquation;
    use Identity;
    use Authority;
    use Notifiable;
    use TradeAuth;
    use ReceiptAuth;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_auth',
        'account',
        'password',
        'email',
        'name',
        'status',
        'authority'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * The other attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Set the password.
     *
     * @param string $value
     * 
     * @return void
     */
    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    
    /**
    * Get the uid
    *
    * @return string|null
    */
    public function getUidAttribute(): ?string
    {
        return ($this->exists ? $this->tid : null);
    }
    
    /**
     * Verify if the other status of the user is abnormal.
     *
     * @return void
     * @throws \Exception
     */
    public function verifyHoldStatusOnFail()
    {
        if ($this->exists) {
            if (! $this->status) {
                throw new ExceptionCode(ExceptionCode::SERVICE_REJECTED);
            }
            // You can use the $this->isCaptureRoute($specify = []) function to do some masking
            // You can set $this->getDefaultCaptureRoute() to affect $this->isCaptureRoute() function
            // Verify user other status throw exception
        }
    }
}
