<?php

namespace App\Entities\Member;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Libraries\Traits\Entity\Auth\JWT;
use App\Libraries\Traits\Entity\Log\DataActivity;
use App\Libraries\Traits\Entity\Swap\TimeEquation;
use App\Libraries\Traits\Entity\Swap\Identity;
use Illuminate\Notifications\Notifiable;
use App\Libraries\Traits\Entity\Trade\Auth as TradeAuth;
use App\Libraries\Traits\Entity\Receipt\Auth as ReceiptAuth;

/**
 * Class Auth.
 *
 * @package App\Entities\Member
 */
class Auth extends Authenticatable implements Transformable, JWTSubject
{
    use TransformableTrait;
    use JWT;
    use DataActivity;
    use TimeEquation;
    use Identity;
    use Notifiable;
    use TradeAuth;
    use ReceiptAuth;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_type',
        'source_id',
        'parent_id',
        'parent_level',
        'level',
        'account',
        'oauth_token',
        'password_extract',
        'rebate',
        'remark',
        'delay',
        'freeze',
        'status',
        'unique_auth',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'oauth_token',
        'password_extract',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'freeze' => 'boolean',
        'status' => 'boolean',
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
            // You can use the $this->isCaptureRoute($specify = []) function to do some masking
            // You can set $this->getDefaultCaptureRoute() to affect $this->isCaptureRoute() function
            // Verify user other status throw exception
            if ($this->freeze) {
                throw new ExceptionCode(ExceptionCode::MEMBER_USER_FREEZE);
            }
            // Verify user other status throw exception
            if (! $this->status) {
                throw new ExceptionCode(ExceptionCode::MEMBER_USER_REJECTED);
            }
        }
    }

    /**
     * Get the default capture routes.
     *
     * @return array
     */
    public function getDefaultCaptureRoute(): array
    {
        /* Capture routes */
        return  [
            'auth.user.login',
            'auth.user.signature.login',
            'member.auth.login',
            'member.auth.signature.login',
            'member.auth.logout',
            // Add another route name
        ];
    }
}