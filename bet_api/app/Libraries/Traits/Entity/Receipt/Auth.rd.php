<?php
/*
 >> Information

    Title		: Receipt Auth
    Revision	: 1.0.0
    Notes		:

    Revision History:
    When			Create		When		Edit		Description
    ---------------------------------------------------------------------------
    04-22-2020		Poen		01-04-2021	Poen		Code maintenance.
    ---------------------------------------------------------------------------

 >> About

    file > (app/Libraries/Traits/Entity/Receipt/Auth.php) :
    The functional base class.

    file > (config/receipt.php) :
    The receipt provider about config.

    The receipt configuration needs to be set to sourceables.

    Order operation code format :
    Formdefine code (1 ~ 99) + Sourceable code (1 ~ 99)

    file > (resources/lang/ language dir /receipt.php) :
    Edit language file.

 >> Learn

    Step 1 :
    In App\Entities Model Class, Use App\Libraries\Traits\Entity\Receipt\Auth

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
    In App\Entities Model Class, Use App\Libraries\Traits\Entity\Receipt\Auth

    File : app/Entities/Member/Auth.php

    Example :
    --------------------------------------------------------------------------
    namespace App\Entities\Member;

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

    ==========================================================================

    Custom Definition :

    Usage 1 :
    Get the authentication status of the trading signature.
    Note : You can change the suspension status to terminate the submission.
    Example :
    --------------------------------------------------------------------------
    public function receiptAuthStatus(): bool
    {
       return true;
    }

    Usage 2 :
    Extra processing of source object handle by amount receipt completed.
    Note : You can customize the receipt that needs to be processed after submission.
    Example :
    --------------------------------------------------------------------------
    public function receiptExtra(object $order)
    {
        //
    }

    Usage 3 :
    The list of form receipt types for editor.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Member\Auth as MemberAuth;

    $item = app(MemberAuth::class);

    $forms = $item->heldForms();

    Usage 4 :
    Get a list of form types held by the receipt user.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Member\Auth as MemberAuth;

    $item = app(MemberAuth::class);

    $columns = [
        'type',
        'description'
    ];

    $forms = $item->heldCFormTypes($columns);

    Usage 5 :
    Create the content of the receipt.
    Note : User actions should use this method to submit receipts.
    Example :
    --------------------------------------------------------------------------
    use App\Entities\Member\Auth as MemberAuth;
    use DB;

    $user = MemberAuth::find(1);

    $order = $user->submitReceipt('billing', [
               'label' => 'member-store',
               'content' => 'Billing request.',
               'note' => 'Custom notes 1'
            ]);

    Step 6 :
    Related order receipt.
    Note : Use the order of the existing records to associate, 
    the new data creation time will use the data in the master order.
    Example :
    --------------------------------------------------------------------------
    use App\Entities\Jwt\Auth;
    use App\Entities\Member\Auth as MemberAuth;
    use DB;

    $user = MemberAuth::find(1);

    $order = $user->submitReceipt('billing', [
               'label' => 'member-store',
               'content' => 'Billing request.',
               'note' => 'Custom notes 1'
            ]);

    $system = Auth::find(1);

    // DB Transaction begin
    DB::beginTransaction();

    $order = $order->where('id', $order->id)->lockForUpdate()->first();

    $order2 = $system->submitReceipt('deposit', [
               'label' => 'system-verify',
               'content' => 'Deposit finish.',
               'note' => 'Custom notes 2'
            ], $order);
    // Synchronization update main $order status field

    DB::commit();
    
    // Related order
    // $order->order = $order2->order
    // $order->created_at = $order2->created_at

*/
