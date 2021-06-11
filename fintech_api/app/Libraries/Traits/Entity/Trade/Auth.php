<?php

namespace App\Libraries\Traits\Entity\Trade;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\Trade\OperateExceptionCode as ExceptionCode;
use App\Exceptions\Jwt\AuthExceptionCode;
use App\Libraries\Traits\Entity\Trade\Ables;
use App\Entities\Trade\Operate;
use TokenAuth;
use DB;

trait Auth
{
    use Ables;

    /**
     * The list of currency account types for holder.
     *
     * @var array
     */
    private static $tradeHeldCurrencies;

    /**
     * Get a list of currency model held by the account user.
     *
     * @return array
     */
    public function heldCurrencyModels(): array
    {
        /* Build cache types */
        if (! isset(self::$tradeHeldCurrencies)) {
            $holderClass = get_class($this);
            self::$tradeHeldCurrencies = $this->getTradeAccountables();
            self::$tradeHeldCurrencies = collect(self::$tradeHeldCurrencies)->map(function ($item) use ($holderClass) {
                if ($this->isTradeAccountableAllowed($item) && ($holderModles = $this->takeTradeAccountableHolders($item)) && in_array($holderClass, $holderModles)) {
                    return $item;
                }
                return null;
            })->reject(function ($item) {
                return empty($item);
            })->all();
        }
        return self::$tradeHeldCurrencies;
    }

    /**
     * Check whether the object is an currency account user.
     *
     * @return bool
     */
    public function isCurrencyUser(): bool
    {
        /* Check hold count */
        return (count($this->heldCurrencyModels()) > 0 ? true : false);
    }

    /**
     * Get trade account id.
     *
     * @return int|null
     */
    public function getTradeAccountIdAttribute(): ?int
    {
        if ($this->exists && $this->isCurrencyUser()) {
            return $this->id . str_pad($this->getTradeSourceableCode($this), 2, '0', STR_PAD_LEFT);
        }
        return null;
    }

    /**
     * Get the authentication status of the trading.
     *
     * @return bool
     */
    public function tradeAuthStatus(): bool
    {
        return true;
    }

    /**
     * After the amount trade is completed, the source object is expanded to handle.
     *
     * @param Operate $order
     *
     * @return void
     */
    public function traded(Operate $order)
    {
        //
    }
    
     /**
     * Get a list of currency types held by the account user.
     *
     * @param array $column
     * column string : class
     * column string : type
     * column string : description
     * @param string|null $type
     *
     * @return array
     * @throws \Exception
     */
    public function heldCurrencyTypes(array $column = [], ?string $type = null): array
    {
        /* Check held */
        if (isset($type)) {
            $types = $this->currencyTypes($column, $type);
            if (isset($this->heldCurrencyModels()[$type])) {
                return $types;
            } else {
                throw new ModelNotFoundException('Query Currency: No query results for guards: Unholded type \'' . $type . '\'.');
            }
        } else {
            return array_intersect_key($this->currencyTypes($column), $this->heldCurrencyModels());
        }
    }

    /**
     * Get the trade currency account object for user authentication.
     *
     * @param mixed $accountableAbstract
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function tradeAccount($accountableAbstract): object
    {
        if ($this->exists && TokenAuth::getAuthGuard($this)) {
            /* Check sourceable is allowed for object */
            if (! $this->isTradeSourceableAllowed($this)) {
                throw new ExceptionCode(ExceptionCode::UNAUTHORIZED_OPERATION);
            }
            /* Get accountable name */
            $accountableAbstract = (is_object($accountableAbstract) ? get_class($accountableAbstract) : (is_string($accountableAbstract) ? $accountableAbstract : null));
            /* Check user account type */
            if (! isset($accountableAbstract) || ! in_array($accountableAbstract, $this->heldCurrencyModels())) {
                throw new ExceptionCode(ExceptionCode::ACCOUNTABLE_UNDEFINED);
            }
            /* Check source trade auth status for object */
            if (! $this->tradeAuthStatus()) {
                throw new ExceptionCode(ExceptionCode::ACCOUNT_FROZEN);
            }
            /* Get account model */
            $accountModel = app($accountableAbstract);
            // DB Transaction begin
            DB::beginTransaction();
            $accountId = $this->trade_account_id;
            $account = $accountModel->where('id', $accountId)->lockForUpdate()->first();
            /* Check account and create */
            if (! $account) {
                $account = $accountModel->create([
                    'id' => $accountId,
                    'amount' => 0
                ]);
            }
            DB::commit();
            return $account;
        }
        throw new AuthExceptionCode(AuthExceptionCode::USER_AUTH_FAIL);
    }
}
