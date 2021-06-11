<?php
/*
 >> Information

    Title		: Lottery game draw rules function.(extends GameDraw.php)
    Revision	: 1.0.0
    Notes		:

    Revision History:
    When			Create		When		Edit		Description
    ---------------------------------------------------------------------------
    12-09-2020		Will		12-09-2020	Will		Code maintenance.
    ---------------------------------------------------------------------------

 >> About

    file > (app/Libraries/LotteryGames/Lottery01/GameDrawRules.php) :
    The functional base class.

 >> Learn

    Step 1 :
    Scheduled execution.

    Example :
    --------------------------------------------------------------------------

    use App\Libraries\LotteryGames\Lottery01\GameDrawRules;

    // Game rules lottery.(遊戲規則開獎)
    $gameRules = GameRule::where('game_id', $gameDraw->game_id)->where('status', '1')->get();
    $openRules = [];
    if(!$gameRules->isEmpty()){
        $GameRule = new GameRules($generalOpenArr, $specialOpenArr);
        foreach ($gameRules as $val) {
            $code = $GameRule->lottery01Rule($val->types, $val->rule_json);
            $openRules[$val->id] = $code;
        }
    }

 */