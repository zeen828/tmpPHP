<?php

namespace App\Libraries\Traits\Entity\Trade;

use App\Exceptions\Trade\OperateExceptionCode as ExceptionCode;
use App\Entities\Trade\Operate;
use App\Libraries\Traits\Entity\Trade\Ables;
use App\Notifications\User\Account\Trade;
use Carbon;
use TokenAuth;

trait Currency
{
    use Ables;

    /**
     * The current trade orders.
     *
     * @var array
     */
    private $currencyOrders = [];

    /**
     * The current account id.
     *
     * @var object
     */
    private $currencyAccountId;

    /**
     * The sourceable holder.
     *
     * @var object
     */
    private $currencyHolder;

    /**
     * The sourceable holder models.
     *
     * @var object
     */
    private $currencyHolderModels;

    /**
     * The trade sourceable object.
     *
     * @var object
     */
    private $currencySourceObject;

    /**
     * The time when the transaction was created.
     *
     * @var object
     */
    private $currencyOrderCreatedAt;

    /**
     * The trade parent order number.
     *
     * @var object
     */
    private $currencyOrderParent;

    /**
     * The time when the transaction was updated.
     *
     * @var object
     */
    private $currencyTradeUpdatedAt;

    /**
     * The trade update execution status.
     *
     * @var bool
     */
    private $currencyTradeUpdating = false;

    /**
     * Eloquent bootstrap any operation.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (isset($model->id)) {
                $model->code = hash_hmac('md5', $model->id . ':' . (isset($model->amount) ? $model->amount : '0') . ':' . $model->asLocalTime($model->updated_at), get_class($model));
            } else {
                throw new ExceptionCode(ExceptionCode::INVALID_ACCOUNT_ID);
            }
        });

        static::updating(function ($model) {
            /* Request must be initiated by a trade */
            if (isset($model->id, $model->amount, $model->updated_at) && $model->isTrade()) {
                $model->code = hash_hmac('md5', $model->id . ':' . $model->amount . ':' . $model->asLocalTime($model->updated_at), get_class($model));
            } else {
                throw new ExceptionCode(ExceptionCode::TRADE_UNSTARTED);
            }
        });
    }

    /**
     * Check the trade update execution status.
     *
     * @return bool
     */
    public function isTrade(): bool
    {
        return $this->currencyTradeUpdating;
    }

    /**
     * The key incrementing mode.
     *
     * @var bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Set the currency amount.
     *
     * @param string $value
     * 
     * @return void
     */
    public function setAmountAttribute(string $value)
    {
        $value = $this->amountFormat($value);
        if (! isset($value)) {
            throw new ExceptionCode(ExceptionCode::INVALID_AMOUNT);
        }
        $this->attributes['amount'] = $value;
    }

    /**
     * Get the currency amount.
     *
     * @param mixed $value
     * 
     * @return string|null
     */
    public function getAmountAttribute($value): ?string
    {
        return (isset($value) ? $this->amountFormat($value) : null);
    }

    /**
     * Get trade currency type code.
     *
     * @return string|null
     */
    public function getCurrencyAttribute(): ?string
    {
        return $this->getTradeAccountableType($this);
    }

    /**
    * Get the account id
    *
    * @return string|null
    */
    public function getAccountAttribute(): ?string
    {
        return ($this->exists ? $this->tid : null);
    }

    /**
     * Get the holder type.
     *
     * @return string|null
     */
    public function getHolderTypeAttribute(): ?string
    {
        if (isset($this->holderable_type)) {
            return $this->getTradeSourceableType($this->holderable_type);
        }
        return null;
    }

    /**
     * Get the holder uid.
     *
     * @return string|null
     */
    public function getHolderIdAttribute(): ?string
    {
        if (isset($this->holderable_type, $this->holderable_id)) {
            return app($this->holderable_type)->asPrimaryTid($this->holderable_id);
        }
        return null;
    }
    
    /**
     * Set the holder type to be invalid.
     *
     * @param mixed $value
     * @return void
     */
    public function setHolderableTypeAttribute($value)
    {
        return;
    }

    /**
     * Set the holder id to be invalid.
     *
     * @param mixed $value
     * @return void
     */
    public function setHolderableIdAttribute($value)
    {
        return;
    }

    /**
     * Set account id.
     *
     * @param int $account
     * @return void
     * @throws \Exception
     */
    public function setIdAttribute(int $account)
    {
        /* For create */
        $error = true;
        if ($account >= 100) {
            $type = (int) substr($account, -2);
            if (isset($this->getHolderModels()[$type])) {
                $datetime = Carbon::now();
                $this->attributes['id'] = $account;
                $this->attributes['holderable_type'] = $this->getHolderModels()[$type];
                $this->attributes['holderable_id'] = substr($account, 0, -2);
                if (! isset($this->attributes['created_at'])) {
                    $this->attributes['created_at'] = $datetime;
                }
                if (! isset($this->attributes['updated_at'])) {
                    $this->attributes['updated_at'] = $datetime;
                }
                $error = false;
            }
        }
        if ($error) {
            throw new ExceptionCode(ExceptionCode::INVALID_ACCOUNT_ID);
        }
    }

    /**
     * Get the holder id by account id.
     *
     * @param int $account
     * @return int
     */
    public function getHolderIdByAccountId(int $account): ?int
    {
        if ($account >= 100) {
            $type = (int) substr($account, -2);
            if (isset($this->getHolderModels()[$type])) {
                return substr($account, 0, -2);
            }
        }
        return null;
    }

    /**
     * Get the holder model by account id.
     *
     * @param int $account
     * @return string
     */
    public function getHolderModelByAccountId(int $account): ?string
    {
        if ($account >= 100) {
            $type = (int) substr($account, -2);
            if (isset($this->getHolderModels()[$type])) {
                return $this->getHolderModels()[$type];
            }
        }
        return null;
    }

    /**
     * Get the account id.
     *
     * @param mixed $sourceableAbstract
     * @param int $id
     * @return int|null
     */
    public function asAccountId($sourceableAbstract, int $id): ?int
    {
        /* Get abstract name */
        $sourceableAbstract = (is_object($sourceableAbstract) ? get_class($sourceableAbstract) : (is_string($sourceableAbstract) ? $sourceableAbstract : null));
        /* Get account id */
        if ($id > 0 && isset($sourceableAbstract) && ($type = array_search($sourceableAbstract, $this->getHolderModels())) !== false) {
            return $id . str_pad($type , 2, '0', STR_PAD_LEFT);
        }
        return null;
    }

    /**
     * Check the holder.
     *
     * @param mixed $sourceableAbstract
     * @return bool
     */
    public function isHolder($sourceableAbstract): bool
    {
        /* Get abstract name */
        $sourceableAbstract = (is_object($sourceableAbstract) ? get_class($sourceableAbstract) : (is_string($sourceableAbstract) ? $sourceableAbstract : null));
        /* Check */
        return (isset($sourceableAbstract) && in_array($sourceableAbstract, $this->getHolderModels()) ? true : false);
    }

    /**
     * Get the auth model class name for the holder.
     *
     * @return array
     */
    public function getHolderModels(): array
    {
        if (! isset($this->currencyHolderModels)) {
            $this->currencyHolderModels = [];
            if ($this->isTradeAccountableAllowed($this)) {
                $this->currencyHolderModels = $this->takeTradeAccountableHolders($this);
                $this->currencyHolderModels = (isset($this->currencyHolderModels) ? $this->currencyHolderModels : []);
            }
        }
        return $this->currencyHolderModels;
    }

    /**
     * Find the holder user of this currency account.
     *
     * @return object|null
     */
    public function findHolder(): ?object
    {
        if (isset($this->holderable_type, $this->holderable_id)) {
            return $this->holderable_type::find($this->holderable_id);
        }
        return null;
    }

    /**
     * Set the trading source object to start.
     *
     * @param \Illuminate\Database\Eloquent\Model $object
     * @param Operate $parent
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function beginTradeAmount(object $object, Operate $parent = null): object
    {
        $accountable = get_class($this);
        $sourceable = get_class($object);
        /* Check accountable id */
        if (! $this->exists) {
            throw new ExceptionCode(ExceptionCode::UNKNOWN_OBJECT_FROM_ACCOUNTABLE);
        }
        /* Get currency holder */
        if ($this->currencyAccountId !== $this->id) {
            $this->currencyHolder = $this->findHolder();
        }
        /* Check accountable */
        if (! $this->currencyHolder || ! $this->isTradeAccountableAllowed($accountable)) {
            throw new ExceptionCode(ExceptionCode::ACCOUNTABLE_UNDEFINED);
        }
        /* Check account auth status */
        if (! $this->currencyHolder->tradeAuthStatus()) {
            throw new ExceptionCode(ExceptionCode::ACCOUNT_FROZEN);
        }
        /* Check sourceable */
        if (! $this->isTradeSourceableAllowed($sourceable)) {
            throw new ExceptionCode(ExceptionCode::SOURCEABLE_UNDEFINED);
        }
        /* Check sourceable id */
        if (! isset($object->id)) {
            throw new ExceptionCode(ExceptionCode::UNKNOWN_OBJECT_FROM_SOURCEABLE);
        }
        /* Check source auth status */
        if (! $object->tradeAuthStatus()) {
            throw new ExceptionCode(ExceptionCode::SOURCE_OPERATION_DISABLED);
        }
        /* Check object type id */
        if ($sourceable === get_class($this->currencyHolder) && $object->id === $this->currencyHolder->id) {
            throw new ExceptionCode(ExceptionCode::NON_PERMITTED_TRADE_OBJECT);
        }
        /* Check accounting security */
        if ($this->code !== hash_hmac('md5', $this->id . ':' . $this->amount . ':' . $this->asLocalTime($this->updated_at), get_class($this))) {
            throw new ExceptionCode(ExceptionCode::UNUSUALLY_FROZEN_ACCOUNT);
        }
        /* Set parent order */
        if (isset($parent)) {
            /* Check parent order */
            if (($parent instanceof Operate) && isset($parent->order)) {
                /* Get created time */
                $this->currencyOrderCreatedAt = $parent->asLocalTime($parent->created_at);
                /* Get parent order */
                $parent = $parent->order;
            } else {
                throw new ExceptionCode(ExceptionCode::UNKNOWN_ORDER_FROM_PARENT);
            }
        }

        $this->currencyAccountId = $this->id;

        $this->currencySourceObject = $object;

        $this->currencyTradeUpdatedAt = Carbon::now();

        $this->currencyOrderCreatedAt = (isset($this->currencyOrderCreatedAt) ? $this->currencyOrderCreatedAt : Carbon::now());

        $this->currencyOrderParent = $parent;

        $this->currencyOrders = [];

        return $this;
    }

    /**
     * Amount of income.
     *
     * @param string $amount
     * @param array $memo
     * @return Operate
     * @throws \Exception
     */
    public function amountOfIncome(string $amount, array $memo = []): object
    {
        if (! $this->exists || ! isset($this->currencyAccountId) || $this->currencyAccountId !== $this->id) {
            throw new ExceptionCode(ExceptionCode::TRADE_UNSTARTED);
        }
        if(! $amount = $this->verifyTradeAmount($amount)) {
            throw new ExceptionCode(ExceptionCode::INVALID_AMOUNT);
        }
        $accountable = get_class($this);
        $sourceable = get_class($this->currencySourceObject);
        /* Allow updates */
        $this->currencyTradeUpdating = true;
        /* Update amount */
        $this->update([
            'amount' => bcadd($this->amount, $amount, 12),
            'updated_at' => $this->currencyTradeUpdatedAt
        ]);
        /* Turn off allow updates */
        $this->currencyTradeUpdating = false;
        /* Get code */
        $code = '2' . str_pad($this->getTradeAccountableCode($accountable), 2, '0', STR_PAD_LEFT) . str_pad($this->getTradeSourceableCode($sourceable), 2, '0', STR_PAD_LEFT);
        /* Create order */
        $order = Operate::create([
            'accountable_type' => $accountable,
            'accountable_id' => $this->id,
            'holderable_type' => get_class($this->currencyHolder),
            'holderable_id' => $this->currencyHolder->id,
            'sourceable_type' => $sourceable,
            'sourceable_id' => $this->currencySourceObject->id,
            'operate' => 'income',
            'amount' => $amount,
            'balance' => $this->amount,
            'code'=> $code,
            'parent'=> (isset($this->currencyOrderParent) ? $this->currencyOrderParent : null),
            'memo'=> $memo,
            'month'=> (int) date('m', strtotime($this->currencyOrderCreatedAt)),
            'created_at' => $this->currencyOrderCreatedAt,
            'updated_at' => $this->currencyTradeUpdatedAt
        ]);
        /* Cache parent order */
        $this->currencyOrderParent = (isset($this->currencyOrderParent) ? $this->currencyOrderParent : $order->serial);
        /* Trade extra */
        $this->currencyHolder->traded($order);
        /* Trade orders */
        $this->currencyOrders[] = $order;
        /* Return order */
        return $order;
    }

    /**
     * Amount of expenses.
     *
     * @param string $amount
     * @param array $memo
     * @return Operate
     * @throws \Exception
     */
    public function amountOfExpenses(string $amount, array $memo = []): object
    {
        if (! $this->exists || ! isset($this->currencyAccountId) || $this->currencyAccountId !== $this->id) {
            throw new ExceptionCode(ExceptionCode::TRADE_UNSTARTED);
        }
        if(! $amount = $this->verifyTradeAmount($amount)) {
            throw new ExceptionCode(ExceptionCode::INVALID_AMOUNT);
        }
        if (bccomp($amount, $this->amount, 12) === 1) {
            throw new ExceptionCode(ExceptionCode::INSUFFICIENT_AMOUNT);
        }
        $accountable = get_class($this);
        $sourceable = get_class($this->currencySourceObject);
        /* Allow updates */
        $this->currencyTradeUpdating = true;
        /* Update amount */
        $this->update([
            'amount' => bcsub($this->amount, $amount, 12),
            'updated_at' => $this->currencyTradeUpdatedAt
        ]);
        /* Turn off allow updates */
        $this->currencyTradeUpdating = false;
        /* Get code */
        $code = '1' . str_pad($this->getTradeAccountableCode($accountable), 2, '0', STR_PAD_LEFT) . str_pad($this->getTradeSourceableCode($sourceable), 2, '0', STR_PAD_LEFT);
        /* Create order */
        $order = Operate::create([
            'accountable_type' => $accountable,
            'accountable_id' => $this->id,
            'holderable_type' => get_class($this->currencyHolder),
            'holderable_id' => $this->currencyHolder->id,
            'sourceable_type' => $sourceable,
            'sourceable_id' => $this->currencySourceObject->id,
            'operate' => 'expenses',
            'amount' => $amount,
            'balance' => $this->amount,
            'code'=> $code,
            'parent'=> (isset($this->currencyOrderParent) ? $this->currencyOrderParent : null),
            'memo'=> $memo,
            'month'=> (int) date('m', strtotime($this->currencyOrderCreatedAt)),
            'created_at' => $this->currencyOrderCreatedAt,
            'updated_at' => $this->currencyTradeUpdatedAt
        ]);
        /* Cache parent order */
        $this->currencyOrderParent = (isset($this->currencyOrderParent) ? $this->currencyOrderParent : $order->serial);
        /* Trade extra */
        $this->currencyHolder->traded($order);
        /* Trade orders */
        $this->currencyOrders[] = $order;
        /* Return order */
        return $order;
    }

    /**
     * Trade orders notify.
     *
     * @return bool
     * @throws \Exception
     */
    public function tradeNotify(): bool
    {
        if (! $this->exists || ! isset($this->currencyAccountId) || $this->currencyAccountId !== $this->id) {
            throw new ExceptionCode(ExceptionCode::TRADE_UNSTARTED);
        }
        /* Use notify */
        if (count($this->currencyOrders) > 0 && in_array('Illuminate\Notifications\Notifiable', class_uses($this->currencyHolder))) {
            $this->currencyHolder->notify(new Trade($this->currencyOrders));
            $this->currencyOrders = [];
            return true;
        }
        return false;
    }
}