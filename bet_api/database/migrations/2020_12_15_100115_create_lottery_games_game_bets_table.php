<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotteryGamesGameBetsTable.
 */
class CreateLotteryGamesGameBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // `sourceable_type` VARCHAR(191) NOT NULL COMMENT '交易源 Model' COLLATE 'utf8mb4_unicode_ci',
        // `sourceable_id` BIGINT(20) UNSIGNED NOT NULL COMMENT '交易源 ID',

        Schema::create('lottery_game_bet', function (Blueprint $table) {
            $table->id();

            $table->string('source_type', 255)->nullable()->comment('來源');
            $table->tinyInteger('source_id')->unsigned()->comment('來源_id(Client id)');
            $table->string('user_type', 255)->nullable()->comment('會員');
            $table->bigInteger('user_id')->unsigned()->comment('會員_id');
            $table->bigInteger('game_id')->unsigned()->comment('彩票遊戲_id');
            $table->bigInteger('draw_id')->unsigned()->comment('開獎期數_id');
            $table->string('period')->nullable()->comment('開獎期數');
            $table->bigInteger('rule_id')->unsigned()->comment('彩票遊戲規則_id');
            $table->string('value')->nullable()->comment('下注選項值');
            $table->tinyInteger('quantity')->unsigned()->default(0)->comment('數量');
            $table->decimal('amount', 10, 3)->unsigned()->default(0.00)->comment('下注總金額');
            $table->decimal('profit', 15, 3)->unsigned()->default(0.00)->comment('預估獲利總金額');
            $table->tinyInteger('win_sys')->unsigned()->default(0)->comment('系統中獎0:未開獎1:未中獎2:中獎');
            $table->tinyInteger('win_user')->unsigned()->default(0)->comment('用戶中獎0:未開獎1:未中獎2:中獎');
            $table->tinyInteger('status')->unsigned()->default(1)->comment('狀態0:停用1:啟用');
            $table->timestamps();
            // database append index by table.
            $table->index(['source_type', 'source_id', 'game_id'], 'admin_criteria');
            $table->index(['user_type', 'user_id', 'game_id', 'status'], 'user_criteria');

            $table->index(['source_type', 'source_id', 'game_id', 'draw_id', 'rule_id', 'value', 'win_sys', 'status'], 'query_cron_win');
            $table->index(['source_type', 'source_id', 'game_id', 'draw_id', 'win_sys', 'status'], 'query_cron_lose');
            $table->index(['source_type', 'source_id', 'game_id', 'draw_id', 'status'], 'query_restart_darw');
            $table->index(['source_type', 'source_id', 'game_id', 'draw_id', 'rule_id', 'value', 'status'], 'query_re_rule_darw');
            $table->index(['source_type', 'source_id', 'user_type', 'user_id', 'game_id', 'status'], 'query_user');
        });

        \DB::statement("ALTER TABLE `lottery_game_bet` COMMENT '彩票遊戲訂單紀錄'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_game_bet');
    }
}
