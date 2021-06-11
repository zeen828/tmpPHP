<?php

namespace App\Repositories\System;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\System\DataActivityRepository;
use App\Entities\System\DataActivity;
use App\Validators\System\DataActivityValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Lang;

/**
 * Class DataActivityRepositoryEloquent.
 *
 * @package namespace App\Repositories\System;
 */
class DataActivityRepositoryEloquent extends BaseRepository implements DataActivityRepository
{
    /**
     * quest type.
     *
     * @var object
     */
    private $questType;

    /**
     * The types columns list.
     *
     * @var array
     */
    private static $columns = [
        'type',
        'name'
    ];

    /**
     * The user types list.
     *
     * @var array
     */
    private static $types;

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\\Presenters\\System\\DataActivityPresenter";
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DataActivity::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        // Return empty is to close the validator about create and update on the repository.
        return DataActivityValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    /**
     * Set the quest type in criteria.
     * 
     *  @param string|null $type
     * 
     * @return void
     */
    public function setQuestType(?string $type)
    {
        if (isset($type)) {
            $this->questType = $type;
        } else {
            $this->questType = null;
        }
    }

    /**
     * Get the quest type.
     * 
     * @return string
     */
    public function questType(): ?string
    {
        return $this->questType;
    }

    /**
     * Get a list of data for existing log.
     *
     * @param int $perPage
     * @param string $type 
     *
     * @return array
     */
    public function index(int $perPage = 15, string $type = null): array
    {
        $this->setQuestType($type);
        /* Criteria Index */
        $this->pushCriteria(app('App\Criteria\System\DataActivity\IndexCriteria'));

        $result = $this->paginate($perPage);
        if (isset($result['meta']['pagination']['links'])) {
            unset($result['meta']['pagination']['links']);
        }
        return $result;
    }

    /**
     * Get the log type list.
     *
     * @param array $column
     * column string : type
     * column string : name
     * @param string|null $type
     *
     * @return array
     * @throws \Exception
     */
    public function types(array $column = [], ?string $type = null): array
    {
        /* Use column */
        if (count($column) > 0) {
            $diff = array_unique(array_diff($column, self::$columns));
            /* Check column name */
            if (count($diff) > 0) {
                throw new Exception('Query Activity: Column not found: Unknown column ( \'' . implode('\', \'', $diff) . '\' ) in \'field list\'.');
            }
        }
        /* Build cache */
        if (!isset(self::$types)) {
            self::$types = array_unique(config('activitylog.available_log_name', []));

            $ignoreTypes = array_unique(config('activitylog.ignore_log_name', []));

            self::$types = collect(self::$types)->map(function ($item) use ($ignoreTypes) {
                if (isset($item[0]) && ! in_array($item, $ignoreTypes)) {
                    return [
                        'type' => $item,
                        'name' => Lang::dict('activitylog', 'names.' . $item, 'Undefined')
                    ];
                }
                return null;
            })->reject(function ($item) {
                return empty($item);
            })->keyBy('type')->all();
        }
        /* Return result */
        if (is_null($type)) {
            $types = self::$types;
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
            if (isset(self::$types[$type])) {
                $types = self::$types[$type];
                if (count($column) > 0) {
                    /* Forget column */
                    $forget = array_diff(self::$columns, $column);
                    /* Get result */
                    $types = collect($types)->forget($forget)->all();
                }
            } else {
                throw new ModelNotFoundException('Query Activity: No query results for type: Unknown type \'' . $type . '\'.');
            }
        }

        return $types;
    }
}
