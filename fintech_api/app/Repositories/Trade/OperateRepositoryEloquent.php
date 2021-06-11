<?php

namespace App\Repositories\Trade;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Trade\OperateRepository;
use App\Entities\Trade\Operate;
use App\Validators\Trade\OperateValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\Trade\OperateExceptionCode as ExceptionCode;
use Carbon;
use SystemParameter;
use DB;
use StorageSignature;
use Lang;

/**
 * Class OperateRepositoryEloquent.
 *
 * @package namespace App\Repositories\Trade;
 */
class OperateRepositoryEloquent extends BaseRepository implements OperateRepository
{
    /**
     * Quest account currency.
     *
     * @var object
     */
    private $questCurrency;

    /**
     * Quest user.
     *
     * @var object
     */
    private $questUser;

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\\Presenters\\Trade\\OperatePresenter";
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Operate::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        // Return empty is to close the validator about create and update on the repository.
        return OperateValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Set the quest account currency type and check.
     *
     * @param string|null $type
     * 
     * @return void
     * @throws \Exception
     */
    public function setQuestCurrency(?string $type)
    {
        if (isset($type)) {
            $this->questCurrency = app($this->model())->currencyTypes(['class'], $type)['class'];
        } else {
            $this->questCurrency = null;
        }
    }

    /**
     * Get the quest account currency.
     * 
     * @return string|null
     */
    public function questCurrency(): ?string
    {
        return $this->questCurrency;
    }

    /**
     * Set the quest user in criteria.
     * 
     * @param object|null $user
     * 
     * @return void
     */
    public function setQuestUser(?object $user)
    {
        if (isset($user)) {
            $this->questUser = $user;
        } else {
            $this->questUser = null;
        }
    }

    /**
     * Get the quest user.
     * 
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function questUser(): ?object
    {
        return $this->questUser;
    }
    
    /**
     * Get a list of data for existing trade.
     *
     * @param int $perPage
     * @param string $type
     * @param \Illuminate\Database\Eloquent\Model|null $user
     * 
     * @return array
     * @throws \Exception
     */
    public function index(int $perPage = 15, string $type = null, object $user = null): array
    {
        /* Set quest currency type */
        $this->setQuestCurrency($type);
        /* Set quest user */
        $this->setQuestUser($user);
        /* Criteria Index */
        $this->pushCriteria(app('App\Criteria\Trade\Log\IndexCriteria'));
       
        $result = $this->paginate($perPage);
        if (isset($result['meta']['pagination']['links'])) {
            unset($result['meta']['pagination']['links']);
        }
        return $result;
    }

    /**
     * Get data centered on existing trade's order primary key id.
     *
     * @param string $order
     * @param \Illuminate\Database\Eloquent\Model|null $user
     * @return array
     * @throws \Exception
     */
    public function focusOrder(string $order, object $user = null): array
    {
        if ($parseOrder = $this->model->parseSerial($order)) {
            $months = SystemParameter::getValue('trade_query_limit_months');
            /* Check dete start limit */
            if ($parseOrder['date'] >= Carbon::parse(Carbon::now()->subMonth($months)->format('Y-m-01 00:00:00'))->subDay()->format('Ymd')) {
                $main = $this->model->where('month', $parseOrder['month'])->where('id', $parseOrder['id'])->first();
                /* Check order */
                if (isset($main) && $main->code === $parseOrder['code'] && $main->order === $order) {
                    /* Transformer */
                    $transformer = app($this->presenter())->getTransformer();
                    /* Check holder */
                    if (app($main->accountable_type)->isHolder($main->holderable_type)) {
                        if (isset($user) && (get_class($user) !== $main->holderable_type || $user->id !== $main->holderable_id)) {
                            $main = null;
                        } else {
                            /* Main data */
                            $main = $transformer->transform($main);
                        }
                    } else {
                        $main = null;
                    }
                    /* Sublist */
                    $data = $this->model->where('month', $parseOrder['month'])->where('parent', $order)->get();
                    $data = collect($data)->map(function ($item) use ($transformer, $user) {
                        /* Check holder */
                        if (app($item->accountable_type)->isHolder($item->holderable_type)) {
                            if (isset($user) && (get_class($user) !== $item->holderable_type || $user->id !== $item->holderable_id)) {
                                return null;
                            } else {
                                /* Sub data */
                                return $transformer->transform($item);
                            }
                        }
                        return null;
                    })->reject(function ($item) {
                        return empty($item);
                    })->all();
                    /* Data */
                    if (isset($main)) {
                        array_unshift($data, $main);
                    }
                    if (count($data) > 0) {
                        return ['data' => $data];
                    }
                }
            }
        }
        throw new ModelNotFoundException('No query results for model [' . Operate::class . '] ' . $order);
    }
}