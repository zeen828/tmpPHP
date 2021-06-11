<?php

namespace App\Notifications\User\Account;

use App\Notifications\User\Message\Notice;
use App\Repositories\Receipt\OperateRepository;
use App\Entities\Receipt\Operate;

class Withdraw extends Notice
{
    /**
     * The notice type.
     *
     * @var string
     */
    protected $type = 'withdraw';

    /**
     * Create a new notification instance.
     *
     * @param Operate $order
     * @return void
     */
    public function __construct(Operate $order)
    {
        /* Transformer */
        $transformer = app(app(OperateRepository::class)->presenter())->getTransformer();
        $order = $transformer->transform($order);
        /* Order content formeat */
        $content = [];
        $content['receipt'] = $order['order'];
        $content['created_at'] = $order['created_at'];
        $content['updated_at'] = $order['updated_at'];
        /* Detail */
        $detail = [];
        $detail['amount'] = $order['memo']['note']['amount'];
        $detail['bank'] = $order['memo']['note']['bank'];
        $order['memo']['note'] = [
            'provider' => $order['memo']['note']['provider']
        ];
        $detail['memo'] = $order['memo'];
        $content['detail'] = $detail;
        /* Push message */
        parent::__construct($content, $this->type);
    }
}