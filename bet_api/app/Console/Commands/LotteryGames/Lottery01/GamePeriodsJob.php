<?php

namespace App\Console\Commands\LotteryGames\Lottery01;

use Illuminate\Console\Command;
use App\Repositories\LotteryGames\GameSettingRepository;
use App\Repositories\LotteryGames\GameDrawRepository;
use Carbon;

class GamePeriodsJob extends Command
{
    /**
     * The is game stting repository
     *
     * @var Object
     */
    protected $setting;

    /**
     * The is game draw repository
     *
     * @var Object
     */
    protected $draw;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games-lottery:periods';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lottery game draw cycle establishment procedure.';// 彩票遊戲開獎週期建立程序

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GameSettingRepository $settingRepository, GameDrawRepository $drawRepository)
    {
        parent::__construct();
        $this->setting = $settingRepository;
        $this->draw = $drawRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('[' . date('Y-m-d H:i:s') . '] START');

        $timeZone = 'Asia/Taipei';
        // Get the game settings valid today.(獲得今日有效的遊戲設定)
        $gameSettingList = $this->setting->getGameSettingsNeedDrawValid();
        if ($gameSettingList->isEmpty()) {
            $this->info('[' . date('Y-m-d H:i:s') . '] END');
            return 0;
        }
        foreach ($gameSettingList as $gameItem) {
            // 當下日期(timeZone)
            $nowAt = Carbon::now($timeZone);
            // Number of draw periods starting today.(今日開始開獎期數)
            $no = 0;
            //$no = (int) sprintf('%d%03d%05d', $nowAt->format('Ymd'), $gameItem->id, 0);
            // 控制開始時間(timeZone)
            $controlStartAtStr = sprintf('%s %s', $nowAt->format('Y-m-d'), $gameItem->start_t);
            // 預開獎時間(timeZone)
            $readyAtStr = sprintf('%s 00:00:01', $nowAt->format('Y-m-d'));
            // 控制結束時間(timeZone)
            $controlEndAtStr = sprintf('%s %s', $nowAt->format('Y-m-d'), $gameItem->end_t);
            $controlEndUAt = Carbon::parse($controlEndAtStr, $timeZone)->setTimezone('UTC');
            do {
                $no++;
                $period = sprintf('%d%03d%05d', $nowAt->format('Ymd'), $gameItem->id, $no);
                // 開始下注時間(UTC)
                $startUAt = Carbon::parse($controlStartAtStr, $timeZone)->setTimezone('UTC');
                // 開獎時間(UTC)
                $drawUAt = Carbon::parse($controlStartAtStr, $timeZone)->addSeconds($gameItem->repeat)->setTimezone('UTC');
                $controlStartAtStr = Carbon::parse($controlStartAtStr, $timeZone)->addSeconds($gameItem->repeat);
                // 停止下注時間(UTC)
                $stopUAt = Carbon::parse($controlStartAtStr, $timeZone)->addSeconds($gameItem->repeat)->subSecond($gameItem->stop_enter)->setTimezone('UTC');
                // 預開獎判斷開獎時間(UTC)
                $readyUAt = ($gameItem->reservation == 1)? Carbon::parse($readyAtStr, $timeZone)->setTimezone('UTC') : $drawUAt;
                // query period create
                //$this->draw->createOnlyDrawPeriod($gameItem->id, $no, $drawUAt, $readyUAt, $startUAt, $stopUAt);
                $this->draw->createOnlyDrawPeriod($gameItem->id, $period, $drawUAt, $readyUAt, $startUAt, $stopUAt);
                // 延續計算使用時間搓
                $controlStartAtStr = $drawUAt->setTimezone($timeZone);
                unset($readyUAt);
                unset($stopUAt);
                unset($startUAt);
                // var_dump($controlEndUAt->eq($drawUAt));//=
                // var_dump($controlEndUAt->ne($drawUAt));//!=
                // var_dump($controlEndUAt->gt($drawUAt));//>
                // var_dump($controlEndUAt->gte($drawUAt));//>=
                // var_dump($controlEndUAt->lt($drawUAt));//<
                // var_dump($controlEndUAt->lte($drawUAt));//<=
                // exit();
            } while ($controlEndUAt->gte($drawUAt));
            unset($controlEndUAt);
            unset($controlEndAtStr);
            unset($readyAtStr);
            unset($controlStartAtStr);
            unset($no);
            unset($nowAt);
            unset($gameItem);
        }

        $this->info('[' . date('Y-m-d H:i:s') . '] END');
        return 0;
    }
}
