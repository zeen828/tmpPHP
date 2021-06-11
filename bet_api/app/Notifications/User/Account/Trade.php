<?php

namespace App\Notifications\User\Account;

use App\Notifications\User\Message\Notice;
use App\Repositories\Trade\OperateRepository;
use Lang;

class Trade extends Notice
{
    /**
     * The notice subject.
     *
     * @var string
     */
    protected $subject = 'Transaction Notice';

    /**
     * The notice type.
     *
     * @var string
     */
    protected $type = 'trade';

    /**
     * Create a new notification instance.
     *
     * @param array $orders
     * @return void
     */
    public function __construct(array $orders)
    {
        /* Transformer */
        $transformer = app(app(OperateRepository::class)->presenter())->getTransformer();
        /* Order number */
        $order = null;
        /* Order created at */
        $createdAt = null;
        /* Order updated at */
        $updatedAt = null;
        /* Order detail */
        $detail = collect($orders)->map(function ($item, $key) use ($transformer, &$order, &$createdAt, &$updatedAt) {
            $order = $item->order;
            $createdAt = $item->created_at;
            $updatedAt = $item->updated_at;
            /* Array Info */
            $item = $transformer->transform($item);
            /* Remove item */
            return collect($item)->forget([
                    'order',
                    'serial',
                    'account',
                    'source',
                    'source_name',
                    'source_id',
                    'balance',
                    'code',
                    'created_at',
                    'updated_at',
                ])->all();
        })->all();
        /* Order content formeat */
        $content = [];
        $content['order'] = $order;
        $content['created_at'] = $createdAt;
        $content['updated_at'] = $updatedAt;
        $content['detail'] = $detail;
        /* Push message */
        parent::__construct($this->subject, $content, $this->type);
    }
}
