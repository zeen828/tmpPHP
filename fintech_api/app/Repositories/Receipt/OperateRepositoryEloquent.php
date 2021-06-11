<?php

namespace App\Repositories\Receipt;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Receipt\OperateRepository;
use App\Entities\Receipt\Operate;
use App\Validators\Receipt\OperateValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon;
use SystemParameter;

/**
 * Class OperateRepositoryEloquent.
 *
 * @package namespace App\Repositories\Receipt;
 */
class OperateRepositoryEloquent extends BaseRepository implements OperateRepository
{
    /**
     * quest source.
     *
     * @var object
     */
    private $questSource;

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\\Presenters\\Receipt\\OperatePresenter";
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
     * Set the quest source in criteria.
     * 
     *  @param object|null $source
     * 
     * @return void
     */
    public function setQuestSource(?object $source)
    {
        if (isset($source)) {
            $this->questSource = $source;
        } else {
            $this->questSource = null;
        }
    }

    /**
     * Get the quest source.
     * 
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function questSource(): ?object
    {
        return $this->questSource;
    }
    
     /**
     * Get a list of data for existing receipt.
     *
     * @param int $perPage
     * @param \Illuminate\Database\Eloquent\Model|null $source
     * @return array
     * @throws \Exception
     */
    public function index(int $perPage = 15, object $source = null): array
    {
        /* Set quest source */
        $this->setQuestSource($source);
        /* Criteria Index */
        $this->pushCriteria(app('App\Criteria\Receipt\Log\IndexCriteria'));
       
        $result = $this->paginate($perPage);
        if (isset($result['meta']['pagination']['links'])) {
            unset($result['meta']['pagination']['links']);
        }
        return $result;
    }

    /**
     * Pick the data centered order master serial information on existing receipt's order primary key id.
     *
     * @param string $order
     * @param \Illuminate\Database\Eloquent\Model|null $source
     * @return Operate
     * @throws \Exception
     */
    public function pickOrderMainSerial(string $order, object $source = null): object
    {
        if ($parseOrder = $this->model->parseSerial($order)) {
            $months = SystemParameter::getValue('receipt_query_limit_months');
            /* Check dete start limit */
            if ($parseOrder['date'] >= Carbon::parse(Carbon::now()->subMonth($months)->format('Y-m-01 00:00:00'))->subDay()->format('Ymd')) {
                $main = $this->model->where('month', $parseOrder['month'])->where('id', $parseOrder['id'])->first();
                /* Check order */
                if (isset($main) && $main->code === $parseOrder['code'] && $main->order === $order) {
                    /* Check form */
                    if ($this->model->isReceiptFormdefineAllowed($main->formdefine_type)) {
                        if (isset($source) && (get_class($source) !== $main->sourceable_type || $source->id !== $main->sourceable_id)) {
                            /* All form types */
                            $forms = $this->model->getReceiptFormdefines();
                            foreach ($forms as $code => $form) {
                                if (! $this->model->isReceiptFormdefineAllowed($form)) {
                                    unset($forms[$code]);
                                }
                            }
                            /* Check whether the source holds the sublist order */
                            $inOrder = $this->model->where('month', $parseOrder['month'])->where('parent', $order)->where('sourceable_type', get_class($source))->where('sourceable_id', $source->id)->whereIn('formdefine_code', array_keys($forms))->first();
                            $main = (isset($inOrder) ? $main : null);
                        }
                    } else {
                        $main = null;
                    }
                    /* Main data */
                    if (isset($main)) {
                        return $main;
                    }
                }
            }
        }
        throw new ModelNotFoundException('No query results for model [' . Operate::class . '] ' . $order);
    }

    /**
     * Pick the data centered order last serial information on existing receipt's order primary key id.
     *
     * @param string $order
     * @param \Illuminate\Database\Eloquent\Model|null $source
     * @return Operate
     * @throws \Exception
     */
    public function pickOrderLastSerial(string $order, object $source = null): object
    {
        if ($parseOrder = $this->model->parseSerial($order)) {
            $months = SystemParameter::getValue('receipt_query_limit_months');
            /* Check dete start limit */
            if ($parseOrder['date'] >= Carbon::parse(Carbon::now()->subMonth($months)->format('Y-m-01 00:00:00'))->subDay()->format('Ymd')) {
                $main = $this->model->where('month', $parseOrder['month'])->where('id', $parseOrder['id'])->first();
                /* Check order */
                if (isset($main) && $main->code === $parseOrder['code'] && $main->order === $order) {
                    /* Check form */
                    if ($this->model->isReceiptFormdefineAllowed($main->formdefine_type)) {
                        /* Check whether the source holds the main order */
                        $inOrder = (isset($source) && get_class($source) === $main->sourceable_type && $source->id === $main->sourceable_id ? true : false);
                        $last = (! isset($source) || (isset($source) && $inOrder) ? $main : null);
                        /* Sublist */
                        $data = $this->model->where('month', $parseOrder['month'])->where('parent', $order)->get();
                        /* Check last */
                        collect($data)->map(function ($item) use ($source, $inOrder, &$last) {
                            /* Check holder */
                            if ($this->model->isReceiptFormdefineAllowed($item->formdefine_type)) {
                                /* Check whether the source holds the sublist order */
                                $inOrder = (isset($source) && get_class($source) === $item->sourceable_type && $source->id === $item->sourceable_id ? true : $inOrder);
                                /* Last order */
                                $last = (! isset($source) || (isset($source) && $inOrder) ? $item : $last);
                            }
                        });
                    }
                    /* Last data */
                    if (isset($last)) {
                        return $last;
                    }
                }
            }
        }
        throw new ModelNotFoundException('No query results for model [' . Operate::class . '] ' . $order);
    }

    /**
     * Get data centered on existing receipt's order primary key id.
     *
     * @param string $order
     * @param \Illuminate\Database\Eloquent\Model|null $source
     * @return array
     * @throws \Exception
     */
    public function focusOrder(string $order, object $source = null): array
    {
        if ($parseOrder = $this->model->parseSerial($order)) {
            $months = SystemParameter::getValue('receipt_query_limit_months');
            /* Check dete start limit */
            if ($parseOrder['date'] >= Carbon::parse(Carbon::now()->subMonth($months)->format('Y-m-01 00:00:00'))->subDay()->format('Ymd')) {
                $main = $this->model->where('month', $parseOrder['month'])->where('id', $parseOrder['id'])->first();
                /* Check order */
                if (isset($main) && $main->code === $parseOrder['code'] && $main->order === $order) {
                    /* Transformer */
                    $transformer = app($this->presenter())->getTransformer();
                    /* Check form */
                    if ($this->model->isReceiptFormdefineAllowed($main->formdefine_type)) {
                        if (isset($source) && (get_class($source) !== $main->sourceable_type || $source->id !== $main->sourceable_id)) {
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
                    $data = collect($data)->map(function ($item) use ($transformer, $source) {
                        /* Check holder */
                        if ($this->model->isReceiptFormdefineAllowed($item->formdefine_type)) {
                            if (isset($source) && (get_class($source) !== $item->sourceable_type || $source->id !== $item->sourceable_id)) {
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
