<?php

namespace App\Libraries\Traits\Entity\Receipt;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Lang;

trait Ables
{
    /**
     * The receipt form define editors list.
     *
     * @var array
     */
    private static $receiptFormdefineEditors = [];

    /**
     * The receipt form define list.
     *
     * @var array
     */
    private static $receiptFormdefines;

    /**
     * The receipt sourceable list.
     *
     * @var array
     */
    private static $receiptSourceables;

    /**
     * The form receipt types columns list.
     *
     * @var array
     */
    private static $receiptFormsColumns = [
        'type',
        'description'
    ];

    /**
     * The list of form receipt types.
     *
     * @var array
     */
    private static $receiptForms;

    /**
     * Get the receipt form define list.
     *
     * @return array
     */
    public function getReceiptFormdefines(): array
    {
        /* Cache formdefines */
        if (! isset(self::$receiptFormdefines)) {
            self::$receiptFormdefines = config('receipt.formdefines');
            self::$receiptFormdefines = (is_array(self::$receiptFormdefines) ? self::$receiptFormdefines : []);
            self::$receiptFormdefines = array_unique(collect(self::$receiptFormdefines)->map(function ($item, $key) {
                if (isset($key[0], $item['code'], $item['status']) && $item['code'] > 0 && $item['code'] <= 99) {
                    return $item['code'];
                } else {
                    return null;
                }
            })->reject(function ($item) {
                return empty($item);
            })->all());
            self::$receiptFormdefines = array_flip(self::$receiptFormdefines);
        }
        return self::$receiptFormdefines;
    }

    /**
    * Check receipt form define type return form code number.
    *
    * @param string $type
    *
    * @return int|null
    */
    public function getReceiptFormdefineCode(string $type): ?int
    {
        /* Check the form define type */
        if (in_array($type, $this->getReceiptFormdefines())) {
            return config('receipt.formdefines.' . $type . '.code');
        }
        return null;
    }

    /**
     * Check receipt form define type model return editors models.
     *
     * @param string $type
     * 
     * @return array|null
     */
    public function takeReceiptFormdefineEditors(string $type): ?array
    {
        /* Check the form define type */
        if (in_array($type, $this->getReceiptFormdefines())) {
            if (! isset(self::$receiptFormdefineEditors[$type])) {
                $source = [];
                $editors = config('receipt.formdefines.' . $type . '.editors');
                if (is_array($editors)) {
                    foreach ($editors as $editor) {
                        if (($model = $this->getReceiptSourceableModel($editor)) && ($code = $this->getReceiptSourceableCode($model)) && $this->isReceiptSourceableAllowed($model)) {
                            $source[$code] = $model;
                        }
                    }
                }
                self::$receiptFormdefineEditors[$type] = (count($source) > 0 ? $source : null);
            }
            return self::$receiptFormdefineEditors[$type];
        }
        return null;
    }

    /**
     * Check that the form allowed by the receipt form define type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function isReceiptFormdefineAllowed(string $type): bool
    {
        /* Check the form define type */
        if (in_array($type, $this->getReceiptFormdefines()) && $this->takeReceiptFormdefineEditors($type)) {
            /* Get form define status */
            return (config('receipt.formdefines.' . $type . '.status') ? true : false);
        }
        return false;
    }

    /**
    * Get the receipt sourceable model list.
    *
    * @return array
    */
    public function getReceiptSourceables(): array
    {
        /* Cache sourceables */
        if (! isset(self::$receiptSourceables)) {
            $codes = [];
            self::$receiptSourceables = config('receipt.sourceables');
            self::$receiptSourceables = (is_array(self::$receiptSourceables) ? self::$receiptSourceables : []);
            self::$receiptSourceables = array_unique(collect(self::$receiptSourceables)->map(function ($item, $key) use (&$codes) {
                if (isset($key[0], $item['model'][0], $item['code'], $item['status']) && $item['code'] > 0 && $item['code'] <= 99 && ! in_array($item['code'], $codes)) {
                    $codes[] = $item['code'];
                    return (in_array('App\Libraries\Traits\Entity\Receipt\Auth', class_uses($item['model'])) ? $item['model'] : null);
                } else {
                    return null;
                }
            })->reject(function ($item) {
                return empty($item);
            })->all());
        }
        return self::$receiptSourceables;
    }
    
    /**
     * Check receipt sourceable type model return source type code.
     *
     * @param mixed $abstract
     *
     * @return string|null
     */
    public function getReceiptSourceableType($abstract): ?string
    {
        /* Get abstract name */
        $abstract = (is_object($abstract) ? get_class($abstract) : (is_string($abstract) ? $abstract : null));
        if (is_string($abstract)) {
            /* Get sourceable type code */
            $source = array_search($abstract, $this->getReceiptSourceables());

            return (is_string($source) ? $source : null);
        }
        return null;
    }

    /**
     * Check receipt sourceable type return model name.
     *
     * @param string $type
     *
     * @return string|null
     */
    public function getReceiptSourceableModel(string $type): ?string
    {
        /* Get sourceable type model */
        return (isset($this->getReceiptSourceables()[$type]) ? $this->getReceiptSourceables()[$type] : null);
    }

    /**
     * Check receipt sourceable type model return source code number.
     *
     * @param mixed $abstract
     *
     * @return int|null
     */
    public function getReceiptSourceableCode($abstract): ?int
    {
        /* Get abstract name */
        $abstract = (is_object($abstract) ? get_class($abstract) : (is_string($abstract) ? $abstract : null));
        if (is_string($abstract)) {
            /* Get sourceable type code */
            $source = array_search($abstract, $this->getReceiptSourceables());

            if (is_string($source)) {
                return config('receipt.sourceables.' . $source . '.code');
            }
        }
        return null;
    }

    /**
    * Check that the model allowed by the receipt sourceable type.
    *
    * @param mixed $abstract
    *
    * @return bool
    */
    public function isReceiptSourceableAllowed($abstract): bool
    {
        /* Get sourceable type code */
        if ($source = $this->getReceiptSourceableType($abstract)) {
            /* Get sourceable status */
            return (config('receipt.sourceables.' . $source . '.status') ? true : false);
        }
        return false;
    }

    /**
     * Get the receipt form types.
     *
     * @param array $column
     * column string : type
     * column string : description
     * @param string|null $type
     *
     * @return array
     * @throws \Exception
     */
    public function formTypes(array $column = [], ?string $type = null): array
    {
        /* Use column */
        if (count($column) > 0) {
            $diff = array_unique(array_diff($column, self::$receiptFormsColumns));
            /* Check column name */
            if (count($diff) > 0) {
                throw new Exception('Query Form: Column not found: Unknown column ( \'' . implode('\', \'', $diff) . '\' ) in \'field list\'.');
            }
        }
        /* Build cache reset description */
        if (! isset(self::$receiptForms)) {
            $types = $this->getReceiptFormdefines();
            self::$receiptForms = collect($types)->map(function ($item) {
                if ($this->isReceiptFormdefineAllowed($item)) {
                    return [
                        'type' => $item,
                        'description' => Lang::dict('receipt', 'formdefines.' . $item, $item)
                    ];
                }
                return null;
            })->reject(function ($item) {
                return empty($item);
            })->keyBy('type')->all();
        }
        /* Return result */
        if (is_null($type)) {
            $types = self::$receiptForms;
            if (count($column) > 0) {
                /* Forget column */
                $forget = array_diff(self::$receiptFormsColumns, $column);
                /* Get result */
                $types = collect($types)->map(function ($item) use ($forget) {
                    return collect($item)->forget($forget)->all();
                })->all();
            }
        } else {
            /* Get type */
            if (isset(self::$receiptForms[$type])) {
                $types = self::$receiptForms[$type];
                if (count($column) > 0) {
                    /* Forget column */
                    $forget = array_diff(self::$receiptFormsColumns, $column);
                    /* Get result */
                    $types = collect($types)->forget($forget)->all();
                }
            } else {
                throw new ModelNotFoundException('Query Form: No query results for types: Unknown type \'' . $type . '\'.');
            }
        }

        return $types;
    }
}