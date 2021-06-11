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
use App\Libraries\Traits\Entity\Column\Setting;
use Illuminate\Notifications\Notifiable;
use App\Exceptions\Member\AuthExceptionCode as ExceptionCode;
use SystemParameter;
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
    use Setting;
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
        'unique_auth',
        'account',
        'password',
        'phone',
        'email',
        'name',
        'nickname',
        'agreed_at',
        'setting',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'setting'
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
    protected $dates = [
        'agreed_at'
    ];
    
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
            if (! $this->isCaptureRoute() && (! isset($this->agreed_at) || $this->asLocalTime($this->agreed_at) < SystemParameter::getValue('member_terms_updated_at'))) {
                throw new ExceptionCode(ExceptionCode::TERMS_NOT_AGREED);
            }
            // You can use the $this->isCaptureRoute($specify = []) function to do some masking
            // You can set $this->getDefaultCaptureRoute() to affect $this->isCaptureRoute() function
            // Verify user other status throw exception
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
            'member.auth.agree',
            // Add another route name
        ];
    }

    /**
     * Get options list.
     *
     * @return array
     */
    public function getSettingOptions(): array
    {
        /* Set options list
         * return [
         *    option key => default value,
         * ]
         */
        return [
            'pin' => null,
            'bank' => null,
            'line' => null
        ];
    }

    /**
     * Get the auth pin code for the user.
     *
     * @return string|null
     */
    public function getAuthPin(): ?string
    {
        return (isset($this->setting['pin']) ? $this->setting['pin'] : null);
    }
}