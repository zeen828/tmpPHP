<?php

namespace App\Repositories\Receipt;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Receipt\FormRepository;
use App\Validators\Receipt\FormValidator;
use App\Entities\Receipt\Operate;

/**
 * Class FormRepositoryEloquent.
 *
 * @package namespace App\Repositories\Receipt;
 */
class FormRepositoryEloquent extends BaseRepository implements FormRepository
{
    /**
     * Quest form code number.
     *
     * @var object
     */
    private $questFormCode;

    /**
     * Quest source.
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
        return FormValidator::class;
    }
    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Set the quest form type code in criteria and check.
     * 
     * @param string $type
     *
     * @return void
     */
    public function setForm(string $type)
    {
        $this->questFormCode = $this->model->getReceiptFormdefineCode($this->model->formTypes(['type'], $type)['type']);
    }

    /**
     * Get the quest form type code.
     * 
     * @return int|null
     */
    public function questFormCode(): ?int
    {
        return $this->questFormCode;
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
     * Get a list of data for existing form receipt.
     *
     * @param string $type
     * @param int $perPage
     * @param \Illuminate\Database\Eloquent\Model|null $source
     * @return array
     * @throws \Exception
     */
    public function index(string $type, int $perPage = 15, object $source = null): array
    {
        /* Check and set quest form code */
        $this->setForm($type);
         /* Set quest source */
        $this->setQuestSource($source);
        /* Criteria Index */
        $this->pushCriteria(app('App\Criteria\Receipt\Form\IndexCriteria'));

        $result = $this->paginate($perPage);
        if (isset($result['meta']['pagination']['links'])) {
            unset($result['meta']['pagination']['links']);
        }
        $this->model->quest_formdefine = null;
        return $result;
    }
}
