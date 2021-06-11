<?php

namespace App\Entities\Trade;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Libraries\Traits\Entity\Swap\TimeEquation;
use App\Libraries\Traits\Entity\Trade\Ables;
use App\Exceptions\Trade\OperateExceptionCode as ExceptionCode;

/**
 * Class Operate.
 *
 * @package namespace App\Entities\Trade;
 */
class Operate extends Model implements Transformable
{
    use TransformableTrait;
    use TimeEquation;
    use Ables;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trade_log';
            
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accountable_type',
        'accountable_id',
        'holderable_type',
        'holderable_id',
        'sourceable_type',
        'sourceable_id',
        'operate',
        'amount',
        'balance',
        'code',
        'parent',
        'memo',
        'month',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The other attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Set the currency amount.
     *
     * @param string $value
     * 
     * @return void
     */
    public function setAmountAttribute(string $value)
    {
        if (! $value = $this->verifyTradeAmount($value)) {
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
     * Set the currency balance.
     *
     * @param string $value
     * 
     * @return void
     */
    public function setBalanceAttribute(string $value)
    {
        $value = $this->amountFormat($value);
        if (! isset($value)) {
            throw new ExceptionCode(ExceptionCode::INVALID_BALANCE);
        }
        $this->attributes['balance'] = $value;
    }

    /**
     * Get the currency balance.
     *
     * @param mixed $value
     * 
     * @return string|null
     */
    public function getBalanceAttribute($value): ?string
    {
        return (isset($value) ? $this->amountFormat($value) : null);
    }

    /**
     * Get the parse serial info array.
     *
     * @param string $order
     * @return array|null
     */
    public function parseSerial(string $order): ?array
    {
        if (preg_match('/^[1-9]{1}[0-9]*$/', $order)) { 
            $id = (int) substr($order, 13);
            $year = (int) substr($order, 5, 4);
            $month = (int) substr($order, 9, 2);
            $day = (int) substr($order, 11, 2);
            $code = (int) substr($order, 0, 5);
            $date = date('Ymd', mktime(0, 0, 0, $month, $day, $year));
            $recheckOrder = $code . $date . $id;
            if ($id > 0 && $code >= 10101 && $code <= 29999 && $order == $recheckOrder) {
                return [
                    'id' => $id,
                    'date' => $date,
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                    'code' => $code
                ];
            }
        }
        return null;
    }

    /**
     * Get trade serial number.
     *
     * @return string|null
     */
    public function getSerialAttribute(): ?string
    {
        if (isset($this->id, $this->code, $this->created_at)) {
            return (string) ($this->code . $this->asLocalTime($this->created_at)->format('Ymd') . $this->id);
        }
        return null;
    }

    /**
     * Get trade order number.
     *
     * @return string|null
     */
    public function getOrderAttribute(): ?string
    {
        return (isset($this->parent) ? $this->parent : $this->serial);
    }

    /**
     * Get trade source id.
     *
     * @return string|null
     */
    public function getSourceIdAttribute(): ?string
    {
        if (isset($this->sourceable_type, $this->sourceable_id)) {
            return (string) (in_array('App\Libraries\Traits\Entity\Swap\Identity', class_uses($this->sourceable_type)) ? app($this->sourceable_type)->asPrimaryTid($this->sourceable_id) : $this->sourceable_id);
        }
        return null;
    }

    /**
     * Get trade account uid.
     *
     * @return string|null
     */
    public function getAccountAttribute(): ?string
    {
        if (isset($this->accountable_type, $this->accountable_id)) {
            return (string) (in_array('App\Libraries\Traits\Entity\Swap\Identity', class_uses($this->accountable_type)) ? app($this->accountable_type)->asPrimaryTid($this->accountable_id) : $this->accountable_id);
        }
        return null;
    }

    /**
     * Get trade currency type code.
     *
     * @return string|null
     */
    public function getCurrencyAttribute(): ?string
    {
        if (isset($this->accountable_type)) {
            /* Get accountable type code */
            $currency = $this->getTradeAccountableType($this->accountable_type);

            return (isset($currency) ? $currency : 'Undefined');
        }
        return null;
    }

    /**
     * Get trade source type code.
     *
     * @return string|null
     */
    public function getSourceAttribute(): ?string
    {
        if (isset($this->sourceable_type)) {
            /* Get sourceable type code */
            $source = $this->getTradeSourceableType($this->sourceable_type);

            return (isset($source) ? $source : 'Undefined');
        }
        return null;
    }

    /**
     * Set memo json.
     *
     * @param array $value
     * @return void
     */
    public function setMemoAttribute(array $value)
    {
        $this->attributes['memo'] = json_encode($this->replaceMemo($value));
    }

    /**
     * Get memo.
     *
     * @param mixed $value
     * @return array|null
     */
    public function getMemoAttribute($value): ?array
    {
        return ($this->exists ? $this->allowedMemo(isset($value) ? json_decode($value, true) : []) : null);
    }

    /**
     * Replace option to format memo code.
     *
     * @param array $memo
     * @return array
     */
    private function replaceMemo(array $memo = []): array
    {
        /* Format source options */
        $memo = array_intersect_key($memo, $this->getMemoItem());
        /* Return source options */
        return array_merge(($this->memo ?: []), $memo);
    }

    /**
     * Format the memo code with the allowed options.
     *
     * @param array $memo
     * @return array
     */
    private function allowedMemo(array $memo = []): array
    {
        /* Format source options */
        $memo = array_intersect_key($memo, $this->getMemoItem());
        /* Return source options */
        return array_merge($this->getMemoItem(), $memo);
    }

    /**
     * Get item list.
     *
     * @return array
     */
    public function getMemoItem(): array
    {
        /* Set item list
         * return [
         *    option key => default value,
         * ]
         */
        return [
            // Trade label
            'label' => null,
            // Trade content
            'content' => null,
            // Trade note
            'note' => null,
        ];
    }
}