<?php

namespace App\Entities\Receipt;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Libraries\Traits\Entity\Swap\TimeEquation;
use App\Libraries\Traits\Entity\Receipt\Ables;

/**
 * Class Operate.
 *
 * @package namespace App\Entities\Receipt;
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
    protected $table = 'receipts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sourceable_type',
        'sourceable_id',
        'formdefine_type',
        'formdefine_code',
        'status',
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
     * Get the parse serial info array.
     *
     * @param string $order
     * @return array|null
     */
    public function parseSerial(string $order): ?array
    {
        if (preg_match('/^[1-9]{1}[0-9]*$/i', $order)) { 
            $id = (int) substr($order, 0, -12);
            $year = (int) substr($order, -12, 4);
            $month = (int) substr($order, -8, 2);
            $day = (int) substr($order, -6, 2);
            $code = (int) substr($order, -4);
            $date = date('Ymd', mktime(0, 0, 0, $month, $day, $year));
            $recheckOrder = $id . $date . str_pad($code, 4, '0', STR_PAD_LEFT);
            if ($id > 0 && $code >= 101 && $code <= 9999 && $order == $recheckOrder) {
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
     * Set formdefine type.
     *
     * @param string $value
     * 
     * @return void
     */
    public function setFormdefineTypeAttribute(string $value)
    {
        $this->attributes['formdefine_type'] = $value;
        if (! isset($this->attributes['status'])) {
            $this->attributes['status'] = $value;
        }
    }

    /**
     * Get receipt serial number.
     *
     * @return string|null
     */
    public function getSerialAttribute(): ?string
    {
        if (isset($this->id, $this->code, $this->created_at)) {
            return (string) ($this->id . $this->asLocalTime($this->created_at)->format('Ymd') . str_pad($this->code, 4, '0', STR_PAD_LEFT));
        }
        return null;
    }

    /**
     * Get receipt order number.
     *
     * @return string|null
     */
    public function getOrderAttribute(): ?string
    {
        return (isset($this->parent) ? $this->parent : $this->serial);
    }

    /**
     * Get receipt form type.
     *
     * @return string|null
     */
    public function getFormAttribute(): ?string
    {
        if (isset($this->formdefine_type)) {
            /* Get formdefine type */
            return (in_array($this->formdefine_type, $this->getReceiptFormdefines()) ? $this->formdefine_type : 'Undefined');
        }
        return null;
    }

    /**
     * Get receipt source id.
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
     * Get receipt source type code.
     *
     * @return string|null
     */
    public function getSourceAttribute(): ?string
    {
        if (isset($this->sourceable_type)) {
            /* Get sourceable type code */
            $source = $this->getReceiptSourceableType($this->sourceable_type);

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
            // Receipt label
            'label' => null,
            // Receipt content
            'content' => null,
            // Receipt note
            'note' => null,
        ];
    }
}