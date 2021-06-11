<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotteryGamesGameSettingsTable.
 */
class CreateLotteryGamesGameSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_game_setting', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名稱');
            $table->text('description')->nullable()->comment('描述');
            $table->json('general_data_json')->comment('開獎用資料(JSON)');
            $table->tinyInteger('general_digits')->unsigned()->default(0)->comment('開獎位數');
            $table->tinyInteger('general_repeat')->unsigned()->default(0)->comment('重複號碼0:不重複1:可重複');
            $table->json('special_data_json')->comment('開獎用資料(特別號)(JSON)');
            $table->tinyInteger('special_digits')->unsigned()->default(0)->comment('開獎位數(特別號)');
            $table->tinyInteger('special_repeat')->unsigned()->default(0)->comment('重複號碼(特別號)0:不重複1:可重複');
            $table->string('week')->default('[]')->comment('營運週期[1,2,3,4,5,6,7]');
            //laravel Carbon::now()->dayOfWeek (1 for Monday, 0 for Sunday)
            //php date() N - The ISO-8601 numeric representation of a day (1 for Monday, 7 for Sunday)
            //PS:date (1 for Monday, 7 for Sunday)，Carbon(1 for Monday, 0 for Sunday)，0 is adjusted to 7
            $table->time('start_t')->nullable()->comment('開始時間');
            $table->time('end_t')->nullable()->comment('結束時間');
            $table->integer('stop_enter')->unsigned()->default(60)->comment('截止押注時間(前幾秒)');
            $table->integer('repeat')->unsigned()->default(0)->comment('間格0只開一次不循環(幾秒一間格)');
            $table->tinyInteger('reservation')->unsigned()->default(1)->comment('預開獎0:正常開1:預開');
            $table->decimal('win_rate', 5, 2)->unsigned()->default(0.40)->comment('贏率(100%=100.00)');
            $table->tinyInteger('status')->unsigned()->default(0)->comment('狀態0:停用1:啟用');
            $table->timestamps();
            // database append index by table.
            $table->index(['status'], 'admin_criteria');
            // $table->index(['user_type', 'user_id', 'game_id', 'status'], 'user_criteria');
            $table->index(['week', 'start_t', 'end_t', 'status'], 'query_at');
        });

        \DB::statement("ALTER TABLE `lottery_game_setting` COMMENT '彩票遊戲設定'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_game_setting');
    }
}
