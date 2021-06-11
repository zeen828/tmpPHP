<?php

namespace App\Console\Commands\LotteryGames\Lottery01;

use Illuminate\Console\Command;
// use App\Entities\LotteryGames\GameSetting;
// use App\Entities\LotteryGames\GameDraw;
use App\Repositories\LotteryGames\GameDrawRepository;
//use App\Entities\LotteryGames\GameRule;
use App\Repositories\LotteryGames\GameRuleRepository;
use App\Libraries\LotteryGames\Lottery01\GameDrawRules;

class GameDrawJob extends Command
{
    /**
     * The is game draw repository
     *
     * @var Object
     */
    protected $draw;

    /**
     * The is game rule repository
     *
     * @var Object
     */
    protected $rule;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games-lottery:draw';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lottery game draw procedure.';// 彩票遊戲開獎程序

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GameDrawRepository $drawRepository, GameRuleRepository $ruleRepository)
    {
        parent::__construct();
        $this->draw = $drawRepository;
        $this->rule = $ruleRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('[' . date('Y-m-d H:i:s') . '] START');

        // Temporary game settings.(遊戲設定暫存)
        $gameSettingArray = array();
        // Get target data.(取得目標資料)
        //$gameDrawList = GameDraw::whereRaw('ready_at <= NOW()')->whereNull('general_draw')->where('status', '1')->get();
        $gameDrawList = $this->draw->getNeedDrawPeriod();
        if ($gameDrawList->isEmpty()) {
            $this->info('[' . date('Y-m-d H:i:s') . '] END');
            return 0;
        }
        
        // open draw code Lib
        $GameDrawRule = new GameDrawRules;

        foreach ($gameDrawList as $gameDraw) {
            // Check the game settings temporary data.(檢查遊戲設定暫存資料)
            if (! isset($gameSettingArray[$gameDraw->game_id])) {
                // Create temporary data for game settings.(建立遊戲設定暫存資料)
                //$gameSetting = GameSetting::find($gameDraw->game_id);
                $gameSetting = $gameDraw->rGameSetting;
                $gameSettingArray[$gameDraw->game_id] = array(
                    'general_data_json' => $gameSetting->general_data_json,
                    'general_digits' => $gameSetting->general_digits,
                    'general_repeat' => $gameSetting->general_repeat,
                    'special_data_json' => $gameSetting->special_data_json,
                    'special_digits' => $gameSetting->special_digits,
                    'special_repeat' => $gameSetting->special_repeat,
                );
                unset($gameSetting);
            }

            // General number draw.(一般號碼開獎)
            $generalOpenArr = $GameDrawRule->setGeneraDrawRule($gameSettingArray[$gameDraw->game_id]['general_data_json'], $gameSettingArray[$gameDraw->game_id]['general_digits'], $gameSettingArray[$gameDraw->game_id]['general_repeat']);
            //print_r($generalOpenArr);
            // Special number draw.(特別號碼開獎)
            $specialOpenArr = $GameDrawRule->setSpecialDrawRule($gameSettingArray[$gameDraw->game_id]['special_data_json'], $gameSettingArray[$gameDraw->game_id]['special_digits'], $gameSettingArray[$gameDraw->game_id]['special_repeat']);
            //print_r($specialOpenArr);

            // Game rules lottery.(遊戲規則開獎)
            //$gameRules = GameRule::where('game_id', $gameDraw->game_id)->where('status', '1')->get();
            $gameRules = $this->rule->model()::where('game_id', $gameDraw->game_id)->where('status', '1')->get();
            $openRules = [];
            if(!$gameRules->isEmpty()){
                $GameDrawRule->setDarwCode($generalOpenArr, $specialOpenArr);
                foreach ($gameRules as $val) {
                    $answer = $GameDrawRule->lottery01Rule($val->type_id, $val->rule_json);
                    // 判斷是否又回傳值
                    if (isset($answer['codeVal'])) {
                        $openRules[$val->id] = array(
                            'ruleId' => $val->id,
                            'typeId' => $val->type_id,
                            'name' => $val->name,
                            'codeVal' => $answer['codeVal'],
                        );
                    }
                    unset($answer);
                    unset($val);
                }
            }
            unset($gameRules);
            // print_r($openRules);
            // echo json_encode($openRules);
            // exit();

            // Update lottery information.(更新開獎資料)
            $gameDraw->update([
                'general_draw' => implode(',', $generalOpenArr),
                'special_draw' => implode(',', $specialOpenArr),
                'draw_rule_json' => json_encode($openRules),
            ]);
            unset($generalOpenArr);
            unset($specialOpenArr);
            unset($openRules);
            unset($gameDraw);
        }
        //print_r($gameSettingArray);
        unset($gameSettingArray);

        $this->info('[' . date('Y-m-d H:i:s') . '] END');
        return 0;
    }
}
