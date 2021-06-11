<?php
/*
 >> Information

    Title		: Trade Auth
    Revision	: 1.0.0
    Notes		:

    Revision History:
    When			Create		When		Edit		Description
    ---------------------------------------------------------------------------
    04-22-2020		Poen		11-04-2020	Poen		Code maintenance.
    ---------------------------------------------------------------------------

 >> About

    file > (app/Libraries/Traits/Entity/Trade/Auth.php) :
    The functional base class.

    file > (config/trade.php) :
    The trade provider about config.

    The trade configuration needs to be set to sourceables.

    file > (resources/lang/ language dir /trade.php) :
    Edit language file.

 >> Learn

    Step 1 :
    In App\Entities Model Class, Use App\Libraries\Traits\Entity\Trade\Auth

    File : app/Entities/Jwt/Auth.php

    Example :
    --------------------------------------------------------------------------
    namespace App\Entities\Jwt;

    use Prettus\Repository\Contracts\Transformable;
    use Prettus\Repository\Traits\TransformableTrait;
    use Tymon\JWTAuth\Contracts\JWTSubject;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use App\Libraries\Traits\Entity\Auth\JWT;
    use App\Libraries\Traits\Entity\Trade\Auth as TradeAuth;

    class Auth extends Authenticatable implements Transformable, JWTSubject
    {
        use TransformableTrait;
        use JWT;
        use TradeAuth;

    }

    Step 2 :
    In App\Entities Model Class, Use App\Libraries\Traits\Entity\Trade\Auth

    File : app/Entities/Member/Auth.php

    Example :
    --------------------------------------------------------------------------
    namespace App\Entities\Member;

    use Prettus\Repository\Contracts\Transformable;
    use Prettus\Repository\Traits\TransformableTrait;
    use Tymon\JWTAuth\Contracts\JWTSubject;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use App\Libraries\Traits\Entity\Auth\JWT;
    use App\Libraries\Traits\Entity\Trade\Auth as TradeAuth;

    class Auth extends Authenticatable implements Transformable, JWTSubject
    {
        use TransformableTrait;
        use JWT;
        use TradeAuth;

    }

    ==========================================================================

    Custom Definition :

    Usage 1 :
    Get the authentication status of the trading signature.
    Note : You can change the suspension status to terminate the transaction.
    Example :
    --------------------------------------------------------------------------
    public function tradeAuthStatus(): bool
    {
       return true;
    }

    Usage 2 :
    Extra processing of source object handle by amount trade completed.
    Note : You can customize the transactions that need to be processed after the transaction is completed.
    Example :
    --------------------------------------------------------------------------
    public function traded(Operate $order)
    {
        //
    }

    Usage 3 :
    Get trade account id.
    Example :
    --------------------------------------------------------------------------
    use App\Entities\Member\Auth as MemberAuth;

    $user = MemberAuth::find(1);

    $accountId = $user->trade_account_id;

    Usage 4 :
    Get a list of currency model held by the account user.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Member\Auth as MemberAuth;

    $item = app(MemberAuth::class);

    $currencys = $item->heldCurrencyModels();

    Usage 5 :
    Get a list of currency types held by the account user.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Member\Auth as MemberAuth;

    $item = app(MemberAuth::class);

    $columns = [
        'class',
        'type',
        'description'
    ];

    $currencys = $item->heldCurrencyTypes($columns);

    Usage 6 :
    Get the trade currency account object for user authentication.
    Note : Account transaction operations should use this method to obtain account objects.
    Example :
    --------------------------------------------------------------------------
    use App\Entities\Account\Gold;
    use App\Entities\Jwt\Auth;
    use App\Entities\Member\Auth as MemberAuth;
    use DB;

    $user = MemberAuth::find(1);

    $account = $user->tradeAccount(Gold::class);

    $target = Auth::find(1);

    // DB Transaction begin
    DB::beginTransaction();

    $item = $account->where('id', $account->id)->lockForUpdate()->first();

    $trade = $item->beginTradeAmount($target);
    // Amount of income by trade
    $order = $trade->amountOfIncome(100, [
               'content' => 'Trade income.',
               'note' => [
                  'Custom notes 1'
               ]
            ]);
 
    DB::commit();

*/
