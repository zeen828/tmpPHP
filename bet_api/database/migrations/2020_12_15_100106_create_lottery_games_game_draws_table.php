<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotteryGamesGameDrawsTable.
 */
class CreateLotteryGamesGameDrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_game_draw', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_id')->unsigned()->comment('彩票遊戲_id');
            $table->string('period', 30)->nullable()->comment('開獎期數');
            $table->timestamp('ready_at')->nullable()->comment('準備時間');
            $table->timestamp('draw_at')->nullable()->comment('開獎時間');
            $table->timestamp('start_at')->nullable()->comment('開始下注時間');
            $table->timestamp('stop_at')->nullable()->comment('停止下注時間');
            $table->string('general_draw')->nullable()->comment('開獎');
            $table->string('special_draw')->nullable()->comment('開獎(特別號)');
            $table->json('draw_rule_json')->nullable()->comment('中獎規則(JSON)');
            $table->integer('bet_quantity')->unsigned()->default(0)->comment('押注數量');
            $table->decimal('bet_amount', 15, 3)->unsigned()->default(0)->comment('押注金額');
            $table->integer('draw_quantity')->unsigned()->default(0)->comment('中獎數量');
            $table->decimal('draw_amount', 15, 3)->unsigned()->default(0.000)->comment('中獎金額');
            $table->decimal('draw_rate', 5, 2)->unsigned()->default(0.000)->comment('中獎率(100%=100.00)');
            $table->tinyInteger('redeem')->unsigned()->default(0)->comment('兌獎0:未兌1:已兌');
            $table->tinyInteger('status')->unsigned()->default(1)->comment('狀態0:停用1:啟用');
            $table->timestamps();
            // database append unique by table.
            $table->unique(['game_id', 'period'], 'period');
            // database append index by table.
            $table->index(['game_id'], 'admin_criteria');
            $table->index(['game_id', 'draw_at', 'general_draw', 'status'], 'user_criteria');

            $table->index(['game_id', 'period', 'status'], 'query_period');
            $table->index(['game_id', 'draw_at', 'status'], 'query_draw_at');
            $table->index(['ready_at', 'general_draw', 'special_draw', 'redeem', 'status'], 'query_cron');
            $table->index(['draw_at', 'redeem', 'status'], 'query_cron_redeem');
            $table->index(['game_id', 'draw_at', 'stop_at', 'redeem', 'status'], 'bet_order');
        });

        \DB::statement("ALTER TABLE `lottery_game_draw` COMMENT '彩票遊戲開號紀錄'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_game_draw');
    }
}
