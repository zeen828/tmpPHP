<?php
/*
 >> Information

    Title		: Currency Account
    Revision	: 1.0.0
    Notes		:

    Revision History:
    When			Create		When		Edit		Description
    ---------------------------------------------------------------------------
    04-21-2020		Poen		11-12-2020	Poen		Code maintenance.
    ---------------------------------------------------------------------------

 >> About

    file > (app/Libraries/Traits/Entity/Trade/Currency.php) :
    The functional base class.

    Amount column and transaction record by transaction.

    file > (config/trade.php) :
    The trade provider about config.

    Order transaction code format :
    Operate code (1 ~ 2) + Accountable code (1 ~ 99) + Sourceable code (1 ~ 99)

    file > (resources/lang/ language dir /trade.php) :
    Edit language file.

 >> Artisan Commands

    Add a new currency account table to database.
    $php artisan make:currency

 >> Learn

    Step 1 :
    Add a new currency table to database.
    Find the created model class in the app/Entities/Account directory.

    Artisan Command :

    $php artisan make:currency Gold

    Step 2 :
    Get attribute data.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Account\Gold;
    use App\Entities\Member\Auth;
    use DB;

    // DB Transaction begin
    DB::beginTransaction();

    $account = Gold::where('id', app(Gold::class)->asAccountId(Auth, 1))->sharedLock()->first();

    // Get the balance amount
    $amount = $account->amount;

    DB::commit();

    Step 3 :
    Amount of income.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Account\Gold;
    use App\Entities\Member\Auth;
    use DB;

    // DB Transaction begin
    DB::beginTransaction();

    $account = Gold::where('id', app(Gold::class)->asAccountId(Auth, 1))->lockForUpdate()->first();

    $target = Auth::find(2);
    // Create trade
    $trade = $account->beginTradeAmount($target);
    // Amount of income by trade
    $order = $trade->amountOfIncome(100, [
               'label' => 'member-trade',
               'content' => 'Trade income.',
               'note' => 'Custom notes 1'
            ]);
    // Amount of income by trade
    $order2 = $trade->amountOfIncome(10, [
               'label' => 'bonus',
               'content' => 'Trade income.',
               'note' => 'Custom notes 2'
            ]);
    // Get the balance amount
    $account->amount;
    // Get order number
    $order->order;
    // Get serial number
    $order->serial;
    // Get order number = $order->order
    $order2->order;
    // Get serial number
    $order2->serial;

    DB::commit();

    Step 4 :
    Amount of expenses.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Account\Gold;
    use App\Entities\Member\Auth;
    use DB;

    // DB Transaction begin
    DB::beginTransaction();

    $account = Gold::where('id', app(Gold::class)->asAccountId(Auth, 1))->lockForUpdate()->first();

    $target = Auth::find(2);
    // Create trade
    $trade = $account->beginTradeAmount($target);
    // Amount of expenses by trade
    $order = $trade->amountOfExpenses(100, [
               'label' => 'member-trade',
               'content' => 'Trade expenditure.',
               'note' => 'Custom notes 1'
            ]);
    // Amount of expenses by trade
    $order2 = $trade->amountOfExpenses(10, [
               'label' => 'fee',
               'content' => 'Trade expenditure.',
               'note' => 'Custom notes 2'
            ]);
    // Get the balance amount
    $account->amount;
    // Get order number
    $order->order;
    // Get serial number
    $order->serial;
    // Get order number = $order->order
    $order2->order;
    // Get serial number
    $order2->serial;

    DB::commit();

    Step 5 :
    Trade orders notify.
    Note : Holder model need to use 'Illuminate\Notifications\Notifiable' trait to enable this feature.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Account\Gold;
    use App\Entities\Member\Auth;
    use DB;

    // DB Transaction begin
    DB::beginTransaction();

    $account = Gold::where('id', app(Gold::class)->asAccountId(Auth, 1))->lockForUpdate()->first();

    $target = Auth::find(2);
    // Create trade
    $trade = $account->beginTradeAmount($target);
    // Amount of expenses by trade
    $trade->amountOfExpenses(100, [
         'label' => 'member-trade',
         'content' => 'Trade expenditure.',
         'note' => 'Custom notes 1'
      ]);
    // Amount of expenses by trade
    $trade->amountOfExpenses(10, [
         'label' => 'fee',
         'content' => 'Trade expenditure.',
         'note' => 'Custom notes 2'
      ]);
    // Transaction notification for orders
    $trade->tradeNotify();

    DB::commit();
    
    Step 6 :
    Related order transactions.
    Note : Use the order of the existing records to associate, 
    the new data creation time will use the data in the master order.

    Example :
    --------------------------------------------------------------------------
    use App\Entities\Account\Gold;
    use App\Entities\Member\Auth;
    use DB;

    // DB Transaction begin
    DB::beginTransaction();

    $gold = app(Gold::class);
    $accountIds = [];
    // Payer account
    $accountIds[] = $gold->asAccountId(Auth, 1);
    // Payee account
    $accountIds[] = $gold->asAccountId(Auth, 2);
    $accounts = $gold->whereIn('id', $accountIds)->lockForUpdate()->get();
    // Get user account
    foreach ($accounts as $object) {
       if ($object->id === $accountIds[0]) {
          $payer = $object;
       } elseif ($object->id === $accountIds[1]) {
          $payee = $object;
       }
    }
    $target = Auth::find(2);
    // Create trade
    $trade = $payer->beginTradeAmount($target);
    // Amount of expenses by trade
    $order = $trade->amountOfExpenses(100, [
               'label' => 'member-trade',
               'content' => 'Trade expenditure.',
               'note' => 'Custom notes 1'
            ]);
    $target = Auth::find(1);
    // Create trade and associate master order
    $trade = $payee->beginTradeAmount($target, $order);
    // Amount of income by trade order
    $order2 = $trade->amountOfIncome(100, [
               'label' => 'member-trade',
               'content' => 'Trade income.',
               'note' => 'Custom notes 2'
            ]);
    // Related order
    // $order->order = $order2->order
    // $order->created_at = $order2->created_at

    DB::commit();

*/
