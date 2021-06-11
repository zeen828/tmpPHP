<?php
/*
 >> Information

    Title		: Receipt Ables
    Revision	: 1.0.0
    Notes		:

    Revision History:
    When			Create		When		Edit		Description
    ---------------------------------------------------------------------------
    11-04-2020		Poen		11-09-2020	Poen		Code maintenance.
    ---------------------------------------------------------------------------

 >> About

    file > (app/Libraries/Traits/Entity/Receipt/Ables.php) :
    The functional base class.

    file > (config/receipt.php) :
    The receipt provider about config.

    file > (resources/lang/ language dir /receipt.php) :
    Edit language file.

 >> Learn

    Step 1 :
    In App\Entities Model Class, Use App\Libraries\Traits\Entity\Receipt\Auth is source.

    In App\Entities Model Class, Use App\Libraries\Traits\Entity\Receipt\Ables is base info.

    File : app/Entities/Jwt/Auth.php

    Example :
    --------------------------------------------------------------------------
    namespace App\Entities\Jwt;

    use Prettus\Repository\Contracts\Transformable;
    use Prettus\Repository\Traits\TransformableTrait;
    use Tymon\JWTAuth\Contracts\JWTSubject;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use App\Libraries\Traits\Entity\Auth\JWT;
    use App\Libraries\Traits\Entity\Receipt\Auth as ReceiptAuth;

    class Auth extends Authenticatable implements Transformable, JWTSubject
    {
        use TransformableTrait;
        use JWT;
        use ReceiptAuth;

    }

    Step 2 :
    Get the receipt form define list.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $formdefines = $item->getReceiptFormdefines();

    Step 3 :
    Check receipt form define type return form code number.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $formdefines = $item->getReceiptFormdefines();

    $code = $item->getReceiptFormdefineCode(current($formdefines));

    Step 4 :
    Check receipt form define type model return editors models.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $formdefines = $item->getReceiptFormdefines();

    $editorModles = $item->takeReceiptFormdefineEditors(current($formdefines));

    Step 5 :
    Check that the form allowed by the receipt form define type.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $formdefines = $item->getReceiptFormdefines();

    $status = $item->isReceiptFormdefineAllowed(current($formdefines));

    Step 6 :
    Get the receipt sourceable model list.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $sourceables = $item->getReceiptSourceables();

    Step 7 :
    Check receipt sourceable type model return source type code.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $type = $item->getReceiptSourceableType(Auth::class);

    Step 8 :
    Check receipt sourceable type return model name.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $type = $item->getReceiptSourceableType(Auth::class);

    $model = $item->getReceiptSourceableModel($type);

    Step 9 :
    Check receipt sourceable type model return source code number.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $code = $item->getReceiptSourceableCode(Auth::class);

    Step 10 :
    Check that the model allowed by the receipt sourceable type.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $status = $item->isReceiptSourceableAllowed(Auth::class);

    Step 11 :
    Get the receipt currency types.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;

    $item = app(Auth::class);

    $columns = [
        'type',
        'description'
    ];

    $currencys = $item->formTypes($columns);

*/