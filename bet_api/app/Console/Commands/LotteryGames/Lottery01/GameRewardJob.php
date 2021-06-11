<?php

namespace App\Console\Commands\LotteryGames\Lottery01;

use Illuminate\Console\Command;
use App\Repositories\LotteryGames\GameDrawRepository;
use App\Repositories\LotteryGames\GameBetRepository;

use App\Entities\Account\Gold;
use App\Entities\Jwt\Auth;
use App\Entities\Member\Auth as MemberAuth;
use DB;

class GameRewardJob extends Command
{
    /**
     * The is game draw repository
     *
     * @var Object
     */
    protected $draw;

    /**
     * The is game draw repository
     *
     * @var Object
     */
    protected $bet;

    /**
     * Number of periods per processing
     *
     * @var integer
     */
    protected $row = 20;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games-lottery:reward';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute winning lottery rewards.';// 發放中獎彩單獎勵

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GameDrawRepository $drawRepository, GameBetRepository $betRepository)
    {
        parent::__construct();
        $this->draw = $drawRepository;
        $this->bet = $betRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('[' . date('Y-m-d H:i:s') . '] START');

        // 取未開獎的
        $this->draw->pushCriteria(app('App\Criteria\LotteryGames\GameDraw\JobGameRewardCriteria'));
        $drawList = $this->draw->paginate($this->row);
        if ($drawList['meta']['pagination']['total'] == 0) {
            $this->info('[' . date('Y-m-d H:i:s') . '] END');
            return 0;
        }
        foreach ($drawList['data'] as $draw) {
            // 更新未中獎的
            $this->bet->model()::where([
                'draw_id' => $draw['id'],
                'win_sys' => '1',// 0:未開獎1:未中獎2:中獎
                'win_user' => '0',// 0:未開獎1:未中獎2:中獎
                'status' => '1',
            ])->update(['win_user' => '1']);
            // 取中獎的
            $betList = $this->bet->model()::where([
                'draw_id' => $draw['id'],
                'win_sys' => '2',// 0:未開獎1:未中獎2:中獎
                'win_user' => '0',// 0:未開獎1:未中獎2:中獎
                'status' => '1',
            ])->get();
            $count = $betList->count();
            $this->info('[' . date('Y-m-d H:i:s') . '] Query ' . $draw['period'] . '(' . $draw['id'] . ') bet win list count ' . $count);
            unset($count);
            if ($betList->isEmpty()) {
                $this->draw->update(['redeem'=>'1'], $draw['id']);
                continue;// 跳出這一次
            }
            foreach ($betList as $bet) {
                // 發送獎金(本金 + 獲利)
                if (empty($bet->profit)) {
                    continue;// 跳出這一次
                }
                //$user = MemberAuth::find($bet->user_id);
                $user = app($bet->user_type)->find($bet->user_id);
                if (empty($user)) {
                    continue;// 跳出這一次
                }
                $account = $user->tradeAccount(Gold::class);// User金幣錢包
                //$target = Auth::find($bet->source_id);// 發送者
                $target = app($bet->source_type)->find($bet->source_id);// 發送者
                // DB Transaction begin
                DB::beginTransaction();
                $item = $account->where('id', $account->id)->lockForUpdate()->first();
                $trade = $item->beginTradeAmount($target);
                // Amount of income by trade
                $order = $trade->amountOfIncome($bet->profit, [
                    'label' => 'BET_WIN_REWARD',
                    'content' => 'INCOME',
                    'note' => array(
                        'betId' => $bet->id,
                        'drawId' => $bet->draw_id,
                        'ruleId' => $bet->rule_id,
                        'value' => $bet->value,
                        'amount' => $bet->amount,
                        'profit' => $bet->profit,
                    )
                ]);
                $bet->win_user = $bet->win_sys;
                $bet->save();
                DB::commit();
                unset($order);
                unset($trade);
                unset($item);
                unset($target);
                unset($account);
                unset($user);
                unset($bet);
            }
            $this->draw->update(['redeem'=>'1'], $draw['id']);
            unset($betList);
            unset($draw);
        }
        unset($drawList);

        $this->info('[' . date('Y-m-d H:i:s') . '] END');
        return 0;
    }
}
