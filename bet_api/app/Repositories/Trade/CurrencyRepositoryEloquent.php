<?php

namespace App\Repositories\Trade;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Trade\CurrencyRepository;
use App\Validators\Trade\CurrencyValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Entities\Trade\Operate;
use DB;

/**
 * Class CurrencyRepositoryEloquent.
 *
 * @package namespace App\Repositories\Trade;
 */
class CurrencyRepositoryEloquent extends BaseRepository implements CurrencyRepository
{
    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\\Presenters\\Trade\\CurrencyPresenter";
    }

    /**
     * Specify Model class name
     *
     * @return string
     * @throws \Exception
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
        return CurrencyValidator::class;
    }
    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Set the account currency type and check.
     *
     * @param string $type
     *
     * @return void
     * @throws \Exception
     */
    public function setCurrency(string $type)
    {
        $this->model = app(app($this->model())->currencyTypes(['class'], $type)['class']);
    }

    /**
     * Get a list of data for existing currency account.
     *
     * @param string $type
     * @param int $perPage
     *
     * @return array
     */
    public function index(string $type, int $perPage = 15): array
    {
        /* Check and set model */
        $this->setCurrency($type);
        /* Criteria Index */
        $this->pushCriteria(app('App\Criteria\Trade\Account\IndexCriteria'));

        $result = $this->paginate($perPage);
        if (isset($result['meta']['pagination']['links'])) {
            unset($result['meta']['pagination']['links']);
        }

        return $result;
    }

    /**
     * Get data centered on existing currency account's primary key id.
     *
     * @param string $type
     * @param int $id
     *
     * @return array
     * @throws \Exception
     */
    public function focusAccountId(string $type, int $id): array
    {
        /* Check and set model */
        $this->setCurrency($type);
        /* Holder model for user */
        $holdrModel = $this->model->getHolderModelByAccountId($id);
        /* Holder id for user */
        $holdrId = $this->model->getHolderIdByAccountId($id);
        /* Check is holder */
        if (isset($holdrModel, $holdrId)) {
            // DB Transaction begin
            DB::beginTransaction();
            $account = $this->model->where('id', $id)->sharedLock()->first();
            /* Check account and create */
            if (! $account && $holdrModel::find($holdrId)) {
                DB::commit();
                DB::beginTransaction();
                $account = $this->model->where('id', $id)->lockForUpdate()->first();
                if (! $account) {
                    $account = $this->model->create([
                        'id' => $id,
                        'amount' => 0
                    ]);
                }
            }
            DB::commit();
            if ($account) {
                /* Transformer */
                $transformer = app($this->presenter())->getTransformer();
                /* Array Info */
                return $transformer->transform($account);
            }
        }
        throw new ModelNotFoundException('No query results for model [' . get_class($this->model) . '] ' . $id);
    }
}
