<?php
/*
 >> Information

    Title		: Lottery game draw function.
    Revision	: 1.0.0
    Notes		:

    Revision History:
    When			Create		When		Edit		Description
    ---------------------------------------------------------------------------
    01-04-2021		Will		01-04-2021	Will		Code maintenance.
    ---------------------------------------------------------------------------

 >> About

    file > (app/Libraries/LotteryGames/Lottery01/GameDraw.php) :
    The functional base class.

 >> Learn

    Step 1 :
    Scheduled execution.

    Example :
    --------------------------------------------------------------------------

    use App\Libraries\LotteryGames\Lottery01\GameDraw;

    // Game rules lottery.(遊戲規則開獎)
    $LibGameDraw = new GameDraw();

    // Get game settings.(取得遊戲設定)
    // 資料結構分為一般區與特別號二區域，每區組成為使用開獎號碼JSON、開幾碼和是否重複號碼。
    $gameSetting = $settingRrepository->model()::find($gameId);
    if (empty($gameSetting)) {
        return $response->success(['data' => 'error']);
    }

    // General area draw.(一般區開獎)
    $generalDrawArr = $LibGameDraw->setGeneraDrawRule($gameSetting->general_data_json, $gameSetting->general_digits, $gameSetting->general_repeat);

    // Special area draw.(特別號開獎)
    $specialDrawArr = $LibGameDraw->setSpecialDrawRule($gameSetting->special_data_json, $gameSetting->special_digits, $gameSetting->special_repeat);
 */