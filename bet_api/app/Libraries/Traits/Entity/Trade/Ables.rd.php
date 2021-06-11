<?php
/*
 >> Information

    Title		: Trade Ables
    Revision	: 1.0.0
    Notes		:

    Revision History:
    When			Create		When		Edit		Description
    ---------------------------------------------------------------------------
    04-26-2020		Poen		12-01-2020	Poen		Code maintenance.
    ---------------------------------------------------------------------------

 >> About

    file > (app/Libraries/Traits/Entity/Trade/Ables.php) :
    The functional base class.

    file > (config/trade.php) :
    The trade provider about config.

    file > (resources/lang/ language dir /trade.php) :
    Edit language file.

 >> Learn

    Step 1 :
    In App\Entities Model Class, Use App\Libraries\Traits\Entity\Trade\Auth is source.

    In App\Entities Model Class, Use App\Libraries\Traits\Entity\Trade\Currency is account.

    In App\Entities Model Class, Use App\Libraries\Traits\Entity\Trade\Ables is base info.

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
    Get the trade accountable model list.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $accountables = $item->getTradeAccountables();

    Step 3 :
    Check trade accountable type model return currency type code.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;
    use App\Entities\Account\Gold;

    $item = app(Auth::class);

    $type = $item->getTradeAccountableType(Gold::class);

    Step 4 :
    Check trade accountable type return model name.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;
    use App\Entities\Account\Gold;

    $item = app(Auth::class);

    $type = $item->getTradeAccountableType(Gold::class);

    $model = $item->getTradeAccountableModel($type);

    Step 5 :
    Check trade accountable type model return currency code number.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;
    use App\Entities\Account\Gold;

    $item = app(Auth::class);

    $code = $item->getTradeAccountableCode(Gold::class);

    Step 6 :
    Check trade accountable type model return holders models.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;
    use App\Entities\Account\Gold;

    $item = app(Auth::class);

    $holderModles = $item->takeTradeAccountableHolders(Gold::class);

    Step 7 :
    Check that the model allowed by the trade accountable type.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;
    use App\Entities\Account\Gold;

    $item = app(Auth::class);

    $status = $item->isTradeAccountableAllowed(Gold::class);

    Step 8 :
    Get the trade sourceable model list.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $sourceables = $item->getTradeSourceables();

    Step 9 :
    Check trade sourceable type model return source type code.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $type = $item->getTradeSourceableType(Auth::class);

    Step 10 :
    Check trade sourceable type return model name.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $type = $item->getTradeSourceableType(Auth::class);

    $model = $item->getTradeSourceableModel($type);

    Step 11 :
    Check trade sourceable type model return source code number.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $code = $item->getTradeSourceableCode(Auth::class);

    Step 12 :
    Check that the model allowed by the trade sourceable type.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $status = $item->isTradeSourceableAllowed(Auth::class);

    Step 13 :
    Get the trade currency types.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $columns = [
        'class',
        'type',
        'description'
    ];

    $currencys = $item->currencyTypes($columns);

    Step 14 :
    Get the amount decimal.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $decimal = $item->getAmountDecimal();

    Step 15 :
    Get the single transaction maximum amount.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $max = $item->getSingleMaxAmount();

    Step 16 :
    Get the single transaction minimum amount.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $min = $item->getSingleMinAmount();

    Step 17 :
    Verify the transaction amount format and return the amount.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $amount = $item->verifyTradeAmount('100.00');

    Step 18 :
    Check and format the amount.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $amount = $item->amountFormat('100.00'); 

*/