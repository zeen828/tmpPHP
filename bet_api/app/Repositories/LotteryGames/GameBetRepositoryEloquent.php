<?php

namespace App\Repositories\LotteryGames;

use App\Libraries\Upgrades\BetterBaseRepository as BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LotteryGames\GameBetRepository;
use App\Entities\LotteryGames\GameBet;
use App\Validators\LotteryGames\GameBetValidator;
use TokenAuth;
use App\Entities\Account\Gift;
use App\Entities\Account\Gold;

/**
 * Class GameBetRepositoryEloquent.
 *
 * @package namespace App\Repositories\LotteryGames;
 */
class GameBetRepositoryEloquent extends BaseRepository implements GameBetRepository
{
    /**
     * Temporarily store data on the server
     * Avoid repeated actions for transactions
     *
     * @var Object
     */
    protected $client;

    /**
     * Temporary storage of user data
     * Avoid repeated actions for transactions
     *
     * @var Object
     */
    protected $user;

    /**
     * Temporary storage of user points
     * Transaction use to avoid repeated actions
     *
     * @var Array
     */
    protected $point;

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        // Return empty is close presenter default transformer.
        return "App\Presenters\LotteryGames\GameBetPresenter";
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GameBet::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GameBetValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Refresh user profile.
     *
     * @return void
     */
    public function refreshtUserData()
    {
        /* Get Member User */
        $this->client = TokenAuth::getClient();
        $this->user = TokenAuth::getUser();
    }

    /**
     * Query user currency point.
     *
     * @return void
     */
    public function queryUserPoint()
    {
        $giftAccount = $this->user->tradeAccount(Gift::class);
        $goldAccount = $this->user->tradeAccount(Gold::class);
        $this->point = [
            'total' => $giftAccount->amount + $goldAccount->amount,
            'gift' => $giftAccount->amount,
            'gold' => $goldAccount->amount,
        ];
        return $this->point;
    }

    /**
     * Undocumented function
     *
     * @param [type] $betId
     * @param [type] $amount
     * @return void
     */
    protected function __deductionUserGift($betId, $amount, $order = null)
    {
        $giftAccount = $this->user->tradeAccount(Gift::class);
        $item = $giftAccount->where('id', $giftAccount->id)->lockForUpdate()->first();
        $trade = $item->beginTradeAmount($this->client, $order);
        $order = $trade->amountOfExpenses($amount, [
            'label' => 'PLAY_GAME_BET',
            'content' => 'EXPENSES',
            'note' => array(
                'betId' => $betId,
                'sum' => $amount
            )
        ]);
        return $order;
    }

    /**
     * Undocumented function
     *
     * @param [type] $betId
     * @param [type] $amount
     * @return void
     */
    protected function __deductionUserGold($betId, $amount, $order = null)
    {
        $goldAccount = $this->user->tradeAccount(Gold::class);
        $item = $goldAccount->where('id', $goldAccount->id)->lockForUpdate()->first();
        $trade = $item->beginTradeAmount($this->client, $order);
        $order = $trade->amountOfExpenses($amount, [
            'label' => 'PLAY_GAME_BET',
            'content' => 'EXPENSES',
            'note' => array(
                'betId' => $betId,
                'sum' => $amount
            )
        ]);
        return $order;
    }

    /**
     * Undocumented function
     *
     * @param [type] $gameId
     * @param [type] $drawId
     * @param [type] $period
     * @param [type] $ruleId
     * @param [type] $value
     * @param [type] $amount
     * @param [type] $profit
     * @param [type] $win_sys
     * @return void
     */
    public function lotteryGameBet($gameId, $drawId, $period, $ruleId, $value, $amount, $profit, $win_sys)
    {
        return $this->model->create(
            [
                'source_type' => get_class($this->client),
                'source_id' => $this->client->id,
                'user_type' => get_class($this->user),
                'user_id' => $this->user->id,
                //
                'game_id' => $gameId,
                'draw_id' => $drawId,
                'period' => $period,
                'rule_id' => $ruleId,
                'value' => $value,
                'quantity' => 1,
                'amount' => $amount,
                'profit' => $profit,
                'win_sys' => $win_sys,
                'win_user' => 0,
                'status' => 1,
            ]
        );
    }

    /**
     * Undocumented function
     *
     * @param [type] $betId
     * @param [type] $amount
     * @return void
     */
    public function betDeduction($betId, $amount)
    {
        //$accountGold = $this->user->tradeAccount(Gift::class);
        $order = null;
        // 先處理贈點
        if (!empty($amount) && !empty($this->point['gift'])) {
            if ($this->point['gift'] >= $amount) {
                $deal = $amount;
            } else {
                $deal = $this->point['gift'];
            }
            $order = $this->__deductionUserGift($betId, $deal, $order);
            $amount = $amount - $deal;
        }
        // 後處理一般金幣
        if (!empty($amount)) {
            $order = $this->__deductionUserGold($betId, $amount, $order);
        }
    }
}
