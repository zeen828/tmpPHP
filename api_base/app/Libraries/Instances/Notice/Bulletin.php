<?php

namespace App\Libraries\Instances\Notice;

use App\Entities\Message\Bulletin as BulletinModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Notifications\User\Message\Notice;
use Illuminate\Notifications\DatabaseNotification;
use TokenAuth;
use Carbon;
use Validator;
use Lang;
use DB;
use Exception;

/**
 * Final Class Bulletin.
 *
 * @package namespace App\Libraries\Instances\Notice;
 */
final class Bulletin extends Notice
{
    /**
     * The notice type.
     *
     * @var string
     */
    private static $type = 'bulletin';

    /**
     * The user types list.
     *
     * @var array
     */
    private static $userTypes;

    /**
     * The types columns list.
     *
     * @var array
     */
    private static $columns = [
        'class',
        'type',
        'description'
    ];

    /**
     * Get the user type list.
     *
     * @param array $column
     * column string : class
     * column string : type
     * column string : description
     * @param string|null $guard
     *
     * @return array
     * @throws \Exception
     */
    public static function userTypes(array $column = [], ?string $guard = null): array
    {
        /* Use column */
        if (count($column) > 0) {
            $diff = array_unique(array_diff($column, self::$columns));
            /* Check column name */
            if (count($diff) > 0) {
                throw new Exception('Query Notifiable: Column not found: Unknown column ( \'' . implode('\', \'', $diff) . '\' ) in \'field list\'.');
            }
        }
        /* Build cache reset description */
        if (!isset(self::$userTypes)) {
            $guards = TokenAuth::getGuardModels();

            self::$userTypes = collect($guards)->map(function ($item, $key) {
                if (in_array($item, config('notice.bulletin_notifiables', []))) {
                    return [
                        'class' => $item,
                        'type' => $key,
                        'description' => Lang::dict('auth', 'guards.' . $key, 'Undefined')
                    ];
                } else {
                    return null;
                }
            })->reject(function ($item) {
                return empty($item);
            })->all();
        }
        /* Return result */
        if (is_null($guard)) {
            $types = self::$userTypes;
            if (count($column) > 0) {
                /* Forget column */
                $forget = array_diff(self::$columns, $column);
                /* Get result */
                $types = collect($types)->map(function ($item) use ($forget) {
                    return collect($item)->forget($forget)->all();
                })->all();
            }
        } else {
            /* Get type */
            if (isset(self::$userTypes[$guard])) {
                $types = self::$userTypes[$guard];
                if (count($column) > 0) {
                    /* Forget column */
                    $forget = array_diff(self::$columns, $column);
                    /* Get result */
                    $types = collect($types)->forget($forget)->all();
                }
            } else {
                throw new ModelNotFoundException('Query Notifiable: No query results for types: Unknown type \'' . $guard . '\'.');
            }
        }

        return $types;
    }

    /**
     * Build a bulletin notification message.
     *
     * @param string $userType
     * @param string $subject
     * @param array $content
     * @param string $startTime
     * @param string $endTime
     * @param bool $status
     *
     * @return bool
     * @throws \Exception
     */
    public static function build(string $userType, string $subject, array $content, string $startTime, string $endTime, bool $status = false): bool
    {
        /* Validator */
        try {
            Validator::make([
                'start' => $startTime,
                'end' => $endTime
            ], [
                'start' => 'required|date_format:Y-m-d H:i:s',
                'end' => 'required|date_format:Y-m-d H:i:s'
            ])->validate();
        } catch (\Throwable $e) {
            if ($e instanceof ValidationException) {
                return false;
            }
            throw $e;
        }
        /* Check user type */
        if (($userModel = TokenAuth::getGuardModel($userType)) && in_array('Illuminate\Notifications\Notifiable', class_uses($userModel))) {
            /* Create */
            try {
                BulletinModel::create([
                    'subject' => $subject,
                    'content' => $content,
                    'notifiable_type' => $userModel,
                    'released_at' => ($startTime > $endTime ? $endTime : $startTime),
                    'expired_at' => ($startTime > $endTime ? $startTime : $endTime),
                    'status' => ($status ? 1 : 0),
                ]);
                return true;
            } catch (\Throwable $e) {
                if (strpos($e->getMessage(), '\'PRIMARY\'') === false) {
                    throw $e;
                }
                return false;
            }
        }
        return false;
    }

    /**
     * Capture the bulletin notifications.
     *
     * @param object $user
     *
     * @return void
     */
    public static function capture(object $user)
    {
        /* Check */
        if (TokenAuth::getAuthGuard($user) && ($id = $user->id) && in_array('Illuminate\Notifications\Notifiable', class_uses($user))) {
            $now = Carbon::now()->toDateTimeString();
            try {
                // DB Transaction begin
                DB::beginTransaction();
                $userType = get_class($user);
                /* Select user record */
                $load = DB::table('notification_bulletin_loads')
                ->select('record')
                ->where('id', $id)
                ->where('type', $userType)
                ->lockForUpdate()
                ->first();
                /* Get user record array */
                $record = (isset($load) ? (isset($load->record) ? json_decode($load->record, true): []) : []);
                /* Record reorganize */
                $record = collect($record)->map(function ($expired) use ($now) {
                    /* Remove */
                    if ($expired < $now) {
                        return null;
                    }
                    return $expired;
                })->reject(function ($expired) {
                    return empty($expired);
                })->all();
                /* Unreads bulletins */
                $quest = BulletinModel::where('released_at', '<=', $now);
                $quest = $quest->where('expired_at', '>=', $now);
                $quest = $quest->where('notifiable_type', '=', $userType);
                $quest = $quest->where('status', '=', 1);
                if (count($record) > 0) {
                    $quest = $quest->whereNotIn('id', array_keys($record));
                }
                $bulletins = $quest->orderBy('released_at', 'ASC')->get();
                $bulletins = $bulletins->toArray();
                /* Push bulletins */
                if (count($bulletins) > 0) {
                    /* Update user record */
                    $bulletins = collect($bulletins)->map(function ($bulletin, $key) use ($user, $id, $userType, $now, &$record) {
                        /* Push reads */
                        $record[$bulletin['id']] = $user->asLocalTime($bulletin['expired_at'])->toDateTimeString();
                        /* To database */
                        $notice = [];
                        $notice['id'] = $bulletin['id'];
                        $notice['type'] = Notice::class;
                        $notice['data'] = json_encode((new self($bulletin['subject'], $bulletin['content'], self::$type))->message);
                        $notice['notifiable_id'] = $id;
                        $notice['notifiable_type'] = $userType;
                        $notice['read_at'] = null;
                        $notice['created_at'] = $now;
                        $notice['updated_at'] = $now;
                        return $notice;
                    })->all();
                    /* Insert notification */
                    DB::table(app(DatabaseNotification::class)->getTable())->insert($bulletins);
                    /* Update user record */
                    DB::table('notification_bulletin_loads')->updateOrInsert([
                        'id' => $id,
                        'type' => $userType
                    ], [
                        'record' => json_encode($record)
                    ]);
                }
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollback();
                if (strpos($e->getMessage(), '\'PRIMARY\'') === false) {
                    throw $e;
                }
            }
        }
    }
}
