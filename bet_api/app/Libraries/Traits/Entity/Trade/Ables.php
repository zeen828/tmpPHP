<?php

namespace App\Libraries\Traits\Entity\Trade;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Lang;
use TokenAuth;

trait Ables
{
    /**
     * The trade accountable holders list.
     *
     * @var array
     */
    private static $tradeAccountableHolders = [];

    /**
     * The trade accountable list.
     *
     * @var array
     */
    private static $tradeAccountables;

    /**
     * The trade sourceable list.
     *
     * @var array
     */
    private static $tradeSourceables;

    /**
     * The currency account types columns list.
     *
     * @var array
     */
    private static $tradeCurrenciesColumns = [
        'class',
        'type',
        'description'
    ];

    /**
     * The list of currency account types.
     *
     * @var array
     */
    private static $tradeCurrencies;

    /**
     * Get the trade accountable model list.
     *
     * @return array
     */
    public function getTradeAccountables(): array
    {
        /* Cache accountables */
        if (! isset(self::$tradeAccountables)) {
            $codes = [];
            self::$tradeAccountables = config('trade.accountables');
            self::$tradeAccountables = (is_array(self::$tradeAccountables) ? self::$tradeAccountables : []);
            self::$tradeAccountables = array_unique(collect(self::$tradeAccountables)->map(function ($item, $key) use (&$codes) {
                if (isset($key[0], $item['model'][0], $item['code'], $item['status']) && $item['code'] > 0 && $item['code'] <= 99 && ! in_array($item['code'], $codes)) {
                    $codes[] = $item['code'];
                    return (! in_array('App\Libraries\Traits\Entity\Trade\Auth', class_uses($item['model'])) && in_array('App\Libraries\Traits\Entity\Trade\Currency', class_uses($item['model'])) ? $item['model'] : null);
                } else {
                    return null;
                }
            })->reject(function ($item) {
                return empty($item);
            })->all());
        }
        return self::$tradeAccountables;
    }

    /**
     * Check trade accountable type model return currency type code.
     *
     * @param mixed $abstract
     *
     * @return string|null
     */
    public function getTradeAccountableType($abstract): ?string
    {
        /* Get abstract name */
        $abstract = (is_object($abstract) ? get_class($abstract) : (is_string($abstract) ? $abstract : null));
        if (is_string($abstract)) {
            /* Get accountable type code */
            $currency = array_search($abstract, $this->getTradeAccountables());

            return (is_string($currency) ? $currency : null);
        }
        return null;
    }

    /**
     * Check trade accountable type return model name.
     *
     * @param string $type
     *
     * @return string|null
     */
    public function getTradeAccountableModel(string $type): ?string
    {
        /* Get accountable type model */
        return (isset($this->getTradeAccountables()[$type]) ? $this->getTradeAccountables()[$type] : null);
    }

    /**
    * Check trade accountable type model return currency code number.
    *
    * @param mixed $abstract
    *
    * @return int|null
    */
    public function getTradeAccountableCode($abstract): ?int
    {
        /* Get abstract name */
        $abstract = (is_object($abstract) ? get_class($abstract) : (is_string($abstract) ? $abstract : null));
        if (is_string($abstract)) {
            /* Get accountable type code */
            $currency = array_search($abstract, $this->getTradeAccountables());

            if (is_string($currency)) {
                return config('trade.accountables.' . $currency . '.code');
            }
        }
        return null;
    }

    /**
     * Check trade accountable type model return holders models.
     *
     * @param mixed $abstract
     * 
     * @return array|null
     */
    public function takeTradeAccountableHolders($abstract): ?array
    {
        /* Get accountable type code */
        if ($currency = $this->getTradeAccountableType($abstract)) {
            if (! isset(self::$tradeAccountableHolders[$currency])) {
                $source = [];
                $holders = config('trade.accountables.' . $currency . '.holders');
                if (is_array($holders)) {
                    foreach ($holders as $holder) {
                        if (($model = $this->getTradeSourceableModel($holder)) && ($code = $this->getTradeSourceableCode($model)) && $this->isTradeSourceableAllowed($model) && TokenAuth::getAuthGuard($model)) {
                            $source[$code] = $model;
                        }
                    }
                }
                self::$tradeAccountableHolders[$currency] = (count($source) > 0 ? $source : null);
            }
            return self::$tradeAccountableHolders[$currency];
        }
        return null;
    }

    /**
     * Check that the model allowed by the trade accountable type.
     *
     * @param mixed $abstract
     *
     * @return bool
     */
    public function isTradeAccountableAllowed($abstract): bool
    {
        /* Get accountable type code and confirm the holder */
        if (($currency = $this->getTradeAccountableType($abstract)) && $this->takeTradeAccountableHolders($abstract)) {
            /* Get accountable status */
            return (config('trade.accountables.' . $currency . '.status') ? true : false);
        }
        return false;
    }

    /**
    * Get the trade sourceable model list.
    *
    * @return array
    */
    public function getTradeSourceables(): array
    {
        /* Cache sourceables */
        if (! isset(self::$tradeSourceables)) {
            $codes = [];
            self::$tradeSourceables = config('trade.sourceables');
            self::$tradeSourceables = (is_array(self::$tradeSourceables) ? self::$tradeSourceables : []);
            self::$tradeSourceables = array_unique(collect(self::$tradeSourceables)->map(function ($item, $key) use (&$codes){
                if (isset($key[0], $item['model'][0], $item['code'], $item['status']) && $item['code'] > 0 && $item['code'] <= 99 && ! in_array($item['code'], $codes)) {
                    $codes[] = $item['code'];
                    return (in_array('App\Libraries\Traits\Entity\Trade\Auth', class_uses($item['model'])) && ! in_array('App\Libraries\Traits\Entity\Trade\Currency', class_uses($item['model']))? $item['model'] : null);
                } else {
                    return null;
                }
            })->reject(function ($item) {
                return empty($item);
            })->all());
        }
        return self::$tradeSourceables;
    }
    
    /**
     * Check trade sourceable type model return source type code.
     *
     * @param mixed $abstract
     *
     * @return string|null
     */
    public function getTradeSourceableType($abstract): ?string
    {
        /* Get abstract name */
        $abstract = (is_object($abstract) ? get_class($abstract) : (is_string($abstract) ? $abstract : null));
        if (is_string($abstract)) {
            /* Get sourceable type code */
            $source = array_search($abstract, $this->getTradeSourceables());

            return (is_string($source) ? $source : null);
        }
        return null;
    }

    /**
     * Check trade sourceable type return model name.
     *
     * @param string $type
     *
     * @return string|null
     */
    public function getTradeSourceableModel(string $type): ?string
    {
        /* Get sourceable type model */
        return (isset($this->getTradeSourceables()[$type]) ? $this->getTradeSourceables()[$type] : null);
    }

    /**
     * Check trade sourceable type model return source code number.
     *
     * @param mixed $abstract
     *
     * @return int|null
     */
    public function getTradeSourceableCode($abstract): ?int
    {
        /* Get abstract name */
        $abstract = (is_object($abstract) ? get_class($abstract) : (is_string($abstract) ? $abstract : null));
        if (is_string($abstract)) {
            /* Get sourceable type code */
            $source = array_search($abstract, $this->getTradeSourceables());

            if (is_string($source)) {
                return config('trade.sourceables.' . $source . '.code');
            }
        }
        return null;
    }

    /**
    * Check that the model allowed by the trade sourceable type.
    *
    * @param mixed $abstract
    *
    * @return bool
    */
    public function isTradeSourceableAllowed($abstract): bool
    {
        /* Get sourceable type code */
        if ($source = $this->getTradeSourceableType($abstract)) {
            /* Get sourceable status */
            return (config('trade.sourceables.' . $source . '.status') ? true : false);
        }
        return false;
    }

    /**
     * Get the trade currency types.
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
    public function currencyTypes(array $column = [], ?string $type = null): array
    {
        /* Use column */
        if (count($column) > 0) {
            $diff = array_unique(array_diff($column, self::$tradeCurrenciesColumns));
            /* Check column name */
            if (count($diff) > 0) {
                throw new Exception('Query Currency: Column not found: Unknown column ( \'' . implode('\', \'', $diff) . '\' ) in \'field list\'.');
            }
        }
        /* Build cache reset description */
        if (! isset(self::$tradeCurrencies)) {
            $types = $this->getTradeAccountables();
            self::$tradeCurrencies = collect($types)->map(function ($item, $key) {
                if ($this->isTradeAccountableAllowed($item)) {
                    return [
                        'class' => $item,
                        'type' => $key,
                        'description' => Lang::dict('trade', 'accountables.' . $key, $key)
                    ];
                }
                return null;
            })->reject(function ($item) {
                return empty($item);
            })->all();
        }
        /* Return result */
        if (is_null($type)) {
            $types = self::$tradeCurrencies;
            if (count($column) > 0) {
                /* Forget column */
                $forget = array_diff(self::$tradeCurrenciesColumns, $column);
                /* Get result */
                $types = collect($types)->map(function ($item) use ($forget) {
                    return collect($item)->forget($forget)->all();
                })->all();
            }
        } else {
            /* Get type */
            if (isset(self::$tradeCurrencies[$type])) {
                $types = self::$tradeCurrencies[$type];
                if (count($column) > 0) {
                    /* Forget column */
                    $forget = array_diff(self::$tradeCurrenciesColumns, $column);
                    /* Get result */
                    $types = collect($types)->forget($forget)->all();
                }
            } else {
                throw new ModelNotFoundException('Query Currency: No query results for types: Unknown type \'' . $type . '\'.');
            }
        }

        return $types;
    }

    /**
     * Get the amount decimal.
     *
     * @return int
     */
    public function getAmountDecimal(): int
    {
        $amountDecimal = config('trade.amount_decimal', 0);
        return ($amountDecimal > 12 ? 12 : ($amountDecimal < 0 ? 0 : $amountDecimal));
    }

    /**
     * Get the single transaction maximum amount.
     *
     * @return string
     */
    public function getSingleMaxAmount(): string
    {
        $amountDecimal = $this->getAmountDecimal();
        $maxAmount = config('trade.single_max_amount', '2147483647');
        return (bccomp($maxAmount, '0', $amountDecimal) === 0 || bccomp($maxAmount, '2147483647', $amountDecimal) === 1 ? '2147483647' : $maxAmount);
    }

    /**
     * Get the single transaction minimum amount.
     *
     * @return string
     */
    public function getSingleMinAmount(): string
    {
        $amountDecimal = $this->getAmountDecimal();
        return ($amountDecimal > 0 ? '0' . str_pad('.', $amountDecimal, '0', STR_PAD_RIGHT) . '1': '1');
    }

    /**
     * Verify the transaction amount format and return the amount.
     * 
     * @param string $value
     * 
     * @return string|null
     */
    public function verifyTradeAmount(string $value): ?string
    {
        $amountDecimal = $this->getAmountDecimal();
        if (! preg_match(($amountDecimal > 0 ? '/^(0|[1-9]{1}[0-9]*){1}(\.[0-9]{1,' . $amountDecimal . '})?$/' : '/^([1-9]{1}[0-9]*)+$/'), $value, $matches) || bccomp($value, '0', $amountDecimal) === 0 || bccomp($value, $this->getSingleMaxAmount(), $amountDecimal) === 1) {
            return null;
        }
        return (isset($matches[2]) ? rtrim(rtrim($matches[0], '0'), '.') : $matches[0]);
    }

    /**
     * Check and format the amount.
     * 
     * @param string $value
     * 
     * @return string|null
     */
    public function amountFormat(string $value): ?string
    {
        if (preg_match('/^(0|[1-9]{1}[0-9]*){1}(\.[0-9]{1,12})?$/', $value, $matches)) {
            return (isset($matches[2]) ? rtrim(rtrim($matches[0], '0'), '.') : $matches[0]);
        }
        return null;
    }
}
