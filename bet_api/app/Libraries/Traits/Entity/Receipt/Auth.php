<?php

namespace App\Libraries\Traits\Entity\Receipt;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\Receipt\OperateExceptionCode as ExceptionCode;
use App\Entities\Receipt\Operate;
use App\Libraries\Traits\Entity\Receipt\Ables;
use Carbon;

trait Auth
{
    use Ables;

    /**
     * The list of form receipt types for editor.
     *
     * @var array
     */
    private static $receiptHeldForms;

    /**
     * Get a list of form receipt type held by the editor user.
     *
     * @return array
     */
    public function heldForms(): array
    {
        /* Build cache types */
        if (! isset(self::$receiptHeldForms)) {
            $editorClass = get_class($this);
            self::$receiptHeldForms = $this->getReceiptFormdefines();
            self::$receiptHeldForms = collect(self::$receiptHeldForms)->map(function ($item) use ($editorClass) {
                if ($this->isReceiptFormdefineAllowed($item) && ($editorModles = $this->takeReceiptFormdefineEditors($item)) && in_array($editorClass, $editorModles)) {
                    return $item;
                }
                return null;
            })->reject(function ($item) {
                return empty($item);
            })->all();
        }
        return self::$receiptHeldForms;
    }

    /**
     * Check whether the object is an form receipt user.
     *
     * @return bool
     */
    public function isFormUser(): bool
    {
        /* Check hold count */
        return (count($this->heldForms()) > 0 ? true : false);
    }

    /**
     * Get the authentication status of the trading.
     *
     * @return bool
     */
    public function receiptAuthStatus(): bool
    {
        return true;
    }

    /**
     * After the amount receipt is completed, the source object is expanded to handle.
     *
     * @param Operate $order
     *
     * @return void
     */
    public function receiptExtra(Operate $order)
    {
        //
    }
    
     /**
     * Get a list of form types held by the receipt user.
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
    public function heldFormTypes(array $column = [], ?string $type = null): array
    {
        /* Check held */
        if (isset($type)) {
            $types = $this->formTypes($column, $type);
            if (in_array($type, $this->heldForms())) {
                return $types;
            } else {
                throw new ModelNotFoundException('Query Form: No query results for guards: Unholded type \'' . $type . '\'.');
            }
        } else {
            return array_intersect_key($this->formTypes($column), array_flip($this->heldForms()));
        }
    }

    /**
     * Create the content of the receipt.
     *
     * @param string $type
     * @param array $memo
     * @param Operate $parent
     * @return Operate
     * @throws \Exception
     */
    public function submitReceipt(string $type, array $memo = [], Operate $parent = null): object
    {
        $sourceable = get_class($this);
        /* Check accountable id */
        if (! $this->exists) {
            throw new ExceptionCode(ExceptionCode::UNKNOWN_OBJECT_FROM_SOURCEABLE);
        }
        /* Check sourceable */
        if (! $this->isTradeSourceableAllowed($sourceable)) {
            throw new ExceptionCode(ExceptionCode::SOURCEABLE_UNDEFINED);
        }
        /* Check formdefine */
        if (! $this->isReceiptFormdefineAllowed($type)) {
            throw new ExceptionCode(ExceptionCode::FORMDEFINE_UNDEFINED);
        }
        /* Check user account type */
        if (! in_array($type, $this->heldForms())) {
            throw new ExceptionCode(ExceptionCode::NON_PERMITTED_FORM_OBJECT);
        }
        /* Check source auth status */
        if (! $this->receiptAuthStatus()) {
            throw new ExceptionCode(ExceptionCode::SOURCE_OPERATION_DISABLED);
        }
        /* Set parent order */
        if (isset($parent)) {
            /* Check parent order */
            if (($parent instanceof Operate) && isset($parent->order)) {
                /* Get created time */
                $createdAt = $parent->asLocalTime($parent->created_at);
                /* Update parent order status type */
                $parent->update([
                    'status' => $type
                ]);
            } else {
                throw new ExceptionCode(ExceptionCode::UNKNOWN_ORDER_FROM_PARENT);
            }
        }
        /* Get created at time */
        $createdAt = (isset($createdAt) ? $createdAt : Carbon::now());
        /* Get formdefine code */
        $formdefineCode = $this->getReceiptFormdefineCode($type);
        /* Get code */
        $code = $formdefineCode . str_pad($this->getReceiptSourceableCode($sourceable), 2, '0', STR_PAD_LEFT);
        /* Create order */
        $order = Operate::create([
            'sourceable_type' => $sourceable,
            'sourceable_id' => $this->id,
            'code'=> $code,
            'formdefine_type' => $type,
            'formdefine_code' => $formdefineCode,
            'parent'=> (isset($parent) ? $parent->order : null),
            'memo'=> $memo,
            'month'=> (int) date('m', strtotime($createdAt)),
            'created_at' => $createdAt,
            'updated_at' => Carbon::now()
        ]);
        /* Receipt extra */
        $this->receiptExtra($order);
        /* Return order */
        return  $order;
    }
}