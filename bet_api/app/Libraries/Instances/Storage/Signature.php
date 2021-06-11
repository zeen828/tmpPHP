<?php

namespace App\Libraries\Instances\Storage;

use Illuminate\Redis\Connections\PhpRedisClusterConnection;
use Illuminate\Redis\Connections\PredisClusterConnection;
use Carbon;
use Str;
use Cache;

/**
 * Final Class Signature.
 *
 * @package namespace App\Libraries\Instances\Storage;
 */
final class Signature
{
    /**
     * The cache key prefix name.
     *
     * @var string
     */
    private static $prefix = 'storage:';

    /**
     * The cache key suffix name.
     *
     * @var string
     */
    private static $suffix = ':s';

    /**
     * The signature cache list.
     *
     * @var array
     */
    private static $signatures = [];

    /**
    * Create a code string with 72 bytes.
    *
    * @param array $data
    * @param bool $keep
    *
    * @return void
    */
    private static function outputCode(array $data, bool $keep)
    {
        /* Create auth tag unique code */
        $code = Str::uuid()->getHex(); // 32 bytes
        /* Hash suffix code */
        $code .= substr(hash('crc32b', $code . json_encode($data)), 0, -2); // 6 bytes
        /* Append mode note */
        $code .= dechex($keep ? mt_rand(16, 135) : mt_rand(136, 255)); // 2 bytes
        /* Signature code */
        return $code . hash_hmac('md5', $code, config('signature.secret'));
    }

    /**
    * Check the code string format and ttl status.
    *
    * @param array $string
    * @param bool &$isKeep
    *
    * @return bool
    */
    private static function isCode(string $code, &$isKeep): bool
    {
        $isKeep = false;
        if (preg_match('/^[a-f0-9]{72}$/', $code) && substr($code, -32) === hash_hmac('md5', substr($code, 0, 40), config('signature.secret'))) {
            $isKeep = (hexdec(substr($code, 38, 2)) < 136 ? true : $isKeep);
            return true;
        }
        return false;
    }

    /**
     * Preload the signature code list and increase query speed.
     *
     * @param array $codes
     *
     * @return void
     */
    public static function preload(array $codes = [])
    {
        /* Check codes and format*/
        $codes = array_values(array_diff(array_unique($codes), array_keys(self::$signatures)));
        if (count($codes) > 0) {
            /* Set store key codes */
            $keepKeyCodes = [];
            $interimKeyCodes = [];
            collect($codes)->map(function ($code) use (&$keepKeyCodes, &$interimKeyCodes) {
                if (self::isCode($code, $isKeep)) {
                    if ($isKeep) {
                        $keepKeyCodes[self::$prefix . $code . self::$suffix] = $code;
                    } else {
                        $interimKeyCodes[self::$prefix . $code . self::$suffix] = $code;
                    }
                }
            });
            /* Get cache */
            if (count($keepKeyCodes) > 0 || count($interimKeyCodes) > 0) {
                /* Config */
                $keepStore = config('signature.keep_store');
                $interimStore = config('signature.interim_store');
                $keepDriver = config('cache.stores.' . $keepStore . '.driver');
                $interimDriver = config('cache.stores.' . $interimStore . '.driver');
                /* Same source store */
                if ($keepStore === $interimStore) {
                    $keepKeyCodes = array_merge($keepKeyCodes, $interimKeyCodes);
                    $interimKeyCodes = [];
                }
                /* Interim store */
                if (count($interimKeyCodes) > 0) {
                    /* Redis cluster store */
                    if ($interimDriver === 'redis' && ($connection = Cache::store($interimStore)->connection()) && ($connection instanceof PhpRedisClusterConnection) || ($connection instanceof PredisClusterConnection)) {
                        collect($interimKeyCodes)->map(function ($code, $key) use ($interimStore) {
                            $storage = Cache::store($interimStore)->get($key);
                            self::$signatures[$code] = ($storage ? $storage : null);
                        });
                    } else {
                        /* Interim store get many */
                        $result = Cache::store($interimStore)->many(array_keys($interimKeyCodes));
                        /* Set cache signatures */
                        collect($result)->map(function ($storage, $key) use ($interimKeyCodes) {
                            self::$signatures[$interimKeyCodes[$key]] = ($storage ? $storage : null);
                        });
                    }
                }
                /* Keep store */
                if (count($keepKeyCodes) > 0) {
                    /* Redis cluster store */
                    if ($keepDriver === 'redis' && ($connection = Cache::store($keepStore)->connection()) && ($connection instanceof PhpRedisClusterConnection) || ($connection instanceof PredisClusterConnection)) {
                        collect($keepKeyCodes)->map(function ($code, $key) use ($keepStore) {
                            $storage = Cache::store($keepStore)->get($key);
                            self::$signatures[$code] = ($storage ? $storage : null);
                        });
                    } else {
                        /* Keep store get many */
                        $result = Cache::store($keepStore)->many(array_keys($keepKeyCodes));
                        /* Set cache signatures */
                        collect($result)->map(function ($storage, $key) use ($keepKeyCodes) {
                            self::$signatures[$keepKeyCodes[$key]] = ($storage ? $storage : null);
                        });
                    }
                }
            }
        }
    }

    /**
     * Obtain the signature code.
     *
     * @param array $data
     * @param int|null $ttl
     *
     * @return string|null
     */
    public static function build(array $data = [], ?int $ttl = 3): ?string
    {
        /* Create auth tag unique code */
        $code = self::outputCode($data, (isset($ttl) ? false : true));
        /* Config */
        $key = self::$prefix . $code . self::$suffix;
        $keepStore = config('signature.keep_store');
        $interimStore = config('signature.interim_store');
        /* Check for key existence */
        if (! Cache::store(isset($ttl) ? $interimStore : $keepStore)->has($key)) {
            if (isset($ttl)) {
                $save = Cache::store($interimStore)->put($key, $data, Carbon::now()->addMinutes($ttl));
            } else {
                $save = Cache::store($keepStore)->forever($key, $data);
            }
            if ($save) {
                /* Cache signature */
                self::$signatures[$code] = $data;
                /* Code 72 bytes */
                return $code;
            }
        }
        return null;
    }

    /**
     * Get the data by signature code.
     *
     * @param string $code
     *
     * @return array|null
     */
    public static function get(string $code): ?array
    {
        /* Check code */
        if (self::isCode($code, $isKeep)) {
            /* Check cache */
            if (isset(self::$signatures[$code])) {
                return self::$signatures[$code];
            } else {
                /* Config */
                $key = self::$prefix . $code . self::$suffix;
                $keepStore = config('signature.keep_store');
                $interimStore = config('signature.interim_store');
                /* Get key value */
                if ($storage = Cache::store($isKeep ? $keepStore : $interimStore)->get($key)) {
                    /* Cache signature */
                    return self::$signatures[$code] = $storage;
                }
            }
        }
        return null;
    }

    /**
     * Forget the data by signature code.
     *
     * @param string $code
     *
     * @return bool
     */
    public static function forget(string $code): bool
    {
        $remove = false;
        /* Check code */
        if (self::isCode($code, $isKeep)) {
            /* Config */
            $key = self::$prefix . $code . self::$suffix;
            $keepStore = config('signature.keep_store');
            $interimStore = config('signature.interim_store');
            /* Remove key */
            if (($remove = Cache::store($isKeep ? $keepStore : $interimStore)->forget($key)) && isset(self::$signatures[$code])) {
                /* Remove cache signature */
                unset(self::$signatures[$code]);
            }
        }
        return $remove;
    }
}
