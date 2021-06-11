<?php

namespace App\Libraries\Instances\System;

use App\Exceptions\System\ParameterExceptionCode as ExceptionCode;
use Illuminate\Validation\ValidationException;
use Cache;
use App\Entities\System\Parameter as SP;
use DB;
use Validator;

/**
 * Final Class Parameter.
 *
 * @package namespace App\Libraries\Instances\System;
 */
final class Parameter
{

    /**
     * The redis cluster slot hash tag name.
     *
     * @var string
     */
    private static $slotTag = '{sys:sp}:';

    /**
     * The parameter list.
     *
     * @var array
     */
    private static $parameters = [];

    /**
     * Set the parameter value.
     *
     * @param string $slug
     * @param string $value
     * @param bool $validator
     *
     * @return bool
     */
    public static function setValue(string $slug, string $value, bool $validator = true): bool
    {
        if (preg_match('/^[a-z0-9_]*$/i', $slug)) {
            /* Validate rule */
            $rules = config('sp.rules');
            if (isset($rules[$slug])) {
                /* Parameter value */
                $config = [
                    'value' => $value
                ];
                /* Validate mode */
                if ($validator) {
                    try {
                        Validator::make($config, [
                            'value' => $rules[$slug]
                        ])->validate();
                    } catch (\Throwable $e) {
                        if ($e instanceof ValidationException) {
                            return false;
                        }
                        throw $e;
                    }
                }
                /* Check slug */
                $result = SP::where('slug', $slug)->first();
                if ($result) {
                    if ($store = config('sp.cache_store')) {
                        /* Update value */
                        DB::beginTransaction();
                        /* Rewrite */
                        if ($result->update($config) && Cache::store($store)->forever(self::$slotTag . $slug, $value)) {
                            self::$parameters[$slug] = $value;
                            DB::commit();
                            return true;
                        }
                        DB::rollback();
                    } else {
                        /* Rewrite */
                        if ($result->update($config)) {
                            self::$parameters[$slug] = $value;
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * Get the parameter value.
     *
     * @param string $slug
     *
     * @return string
     * @throws \Exception
     */
    public static function getValue(string $slug): string
    {
        if (preg_match('/^[a-z0-9_]*$/i', $slug)) {
            /* Validate rule */
            $rules = config('sp.rules');
            if (isset($rules[$slug])) {
                /* Check slug */
                if (isset(self::$parameters[$slug])) {
                    return self::$parameters[$slug];
                }
                /* Get value */
                if ($store = config('sp.cache_store')) {
                    /* Get need sesrch slugs */
                    $lackSlugs = array_values(array_diff(array_keys($rules), array_keys(self::$parameters)));
                    /* Put now slug */
                    if (! in_array($slug, $lackSlugs, true)) {
                        $lackSlugs[] = $slug;
                    }
                    /* Check cache */
                    if (count($lackSlugs) > 0) {
                        /* Set cache store key slugs */
                        $keySlugs = [];
                        collect($lackSlugs)->map(function ($slug) use (&$keySlugs) {
                            /* Set store all key slugs */
                            $keySlugs[self::$slotTag . $slug] = $slug;
                        });
                        /* Cache search */
                        $result = Cache::store($store)->many(array_keys($keySlugs));
                        /* Set cache parameters */
                        collect($result)->map(function ($value, $key) use ($keySlugs) {
                            if (isset($value)) {
                                self::$parameters[$keySlugs[$key]] = $value;
                            }
                        });
                        /* Check slug */
                        if (isset(self::$parameters[$slug])) {
                            return self::$parameters[$slug];
                        }
                    }
                    /* Database search */
                    if (count(self::$parameters) > 0) {
                        $result = SP::select('slug', 'value')->whereNotIn('slug', array_keys(self::$parameters))->get();
                    } else {
                        $result = SP::select('slug', 'value')->get();
                    }
                    /* Set the cache */
                    $putMany = [];
                    collect($result)->map(function ($parameter) use (&$putMany) {
                        if (isset($parameter->value)) {
                            self::$parameters[$parameter->slug] = $parameter->value;
                            $putMany[self::$slotTag . $parameter->slug] = $parameter->value;
                        }
                    });
                    /* Check slug */
                    if (isset(self::$parameters[$slug])) {
                        /* Cache put */
                        if (count($putMany) > 0) {
                            Cache::store($store)->putMany($putMany);
                        }
                        return self::$parameters[$slug];
                    }
                } else {
                    /* Database search */
                    if (count(self::$parameters) > 0) {
                        $result = SP::select('slug', 'value')->whereNotIn('slug', array_keys(self::$parameters))->get();
                    } else {
                        $result = SP::select('slug', 'value')->get();
                    }
                    /* Set the cache */
                    collect($result)->map(function ($parameter) {
                        if (isset($parameter->value)) {
                            self::$parameters[$parameter->slug] = $parameter->value;
                        }
                    });
                    /* Check slug */
                    if (isset(self::$parameters[$slug])) {
                        return self::$parameters[$slug];
                    }
                }
            }
        }
        throw new ExceptionCode(ExceptionCode::UNCAPTURED_PARAMETER, [
            '%slug%' => $slug
        ], [
            '%slug%' => $slug
        ]);
    }
}
